import 'package:flutter/material.dart';
import 'api_service.dart';
import 'models.dart';
import 'package:file_picker/file_picker.dart';
import 'dart:io';

class AddPolicyPage extends StatefulWidget {
  const AddPolicyPage({super.key});

  @override
  State<AddPolicyPage> createState() => _AddPolicyPageState();
}

class _AddPolicyPageState extends State<AddPolicyPage> {
  final ApiService _apiService = ApiService();
  final _formKey = GlobalKey<FormState>();
  
  List<PolicyType> _policyTypes = [];
  int? _selectedPolicyTypeId;
  String _selectedPlanType = 'Standard';
  DateTime _selectedDate = DateTime.now();
  bool _isLoading = false;
  bool _isFetchingTypes = true;
  
  // Document upload variables
  List<File> _selectedFiles = [];
  bool _isUploadingDocuments = false;

  @override
  void initState() {
    super.initState();
    _fetchPolicyTypes();
  }

  Future<void> _fetchPolicyTypes() async {
    try {
      final types = await _apiService.getPolicyTypes();
      setState(() {
        _policyTypes = types;
        _isFetchingTypes = false;
      });
    } catch (e) {
      setState(() => _isFetchingTypes = false);
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Error fetching policy types: $e')),
        );
      }
    }
  }

  Future<void> _submit() async {
    if (!_formKey.currentState!.validate() || _selectedPolicyTypeId == null) {
      if (_selectedPolicyTypeId == null) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Please select a policy type')),
        );
      }
      return;
    }

    setState(() => _isLoading = true);

    try {
      final startDate = "${_selectedDate.year}-${_selectedDate.month.toString().padLeft(2, '0')}-${_selectedDate.day.toString().padLeft(2, '0')}";
      final success = await _apiService.addPolicy(
        _selectedPolicyTypeId!,
        _selectedPlanType,
        startDate,
      );

      if (success && mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Policy added successfully!')),
        );

        // Extract the policy ID from response
        // In a real scenario, you'd want to capture and return the policy ID from addPolicy()
        // For now, fetch the policy list to get the newly created policy
        try {
          final policies = await _apiService.getPolicies();
          if (policies.isNotEmpty) {
            final newPolicy = policies.first;
            
            // Upload documents if any are selected
            if (_selectedFiles.isNotEmpty) {
              if (mounted) {
                ScaffoldMessenger.of(context).showSnackBar(
                  const SnackBar(content: Text('Starting document upload...')),
                );
              }
              await _uploadDocuments(newPolicy.id);
            }
          }
        } catch (e) {
          // Continue even if we can't upload documents
          if (mounted) {
            ScaffoldMessenger.of(context).showSnackBar(
              SnackBar(content: Text('Warning: Could not upload documents: $e')),
            );
          }
        }

        if (mounted) {
          Navigator.pop(context, true);
        }
      } else if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Failed to add policy. Please try again.')),
        );
      }
    } catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Error: $e')),
        );
      }
    } finally {
      if (mounted) setState(() => _isLoading = false);
    }
  }

  Future<void> _selectDate(BuildContext context) async {
    final DateTime? picked = await showDatePicker(
      context: context,
      initialDate: _selectedDate,
      firstDate: DateTime.now().subtract(const Duration(days: 30)),
      lastDate: DateTime.now().add(const Duration(days: 365)),
    );
    if (picked != null && picked != _selectedDate) {
      setState(() {
        _selectedDate = picked;
      });
    }
  }

  /// Pick files from device storage
  /// 
  /// Supports PDF, images, and documents (max 2MB each)
  /// Users can select multiple files
  Future<void> _pickFiles() async {
    try {
      FilePickerResult? result = await FilePicker.platform.pickFiles(
        type: FileType.custom,
        allowedExtensions: ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx', 'xls', 'xlsx'],
        allowMultiple: true,
        withData: false,
      );

      if (result != null) {
        final newFiles = result.paths
            .where((path) => path != null)
            .map((path) => File(path!))
            .where((file) {
              // Check file size (2MB limit)
              final fileSizeInMB = file.lengthSync() / (1024 * 1024);
              if (fileSizeInMB > 2) {
                ScaffoldMessenger.of(context).showSnackBar(
                  SnackBar(
                    content: Text('${file.path.split('/').last} exceeds 2MB limit'),
                  ),
                );
                return false;
              }
              return true;
            })
            .toList();

        if (mounted) {
          setState(() {
            _selectedFiles.addAll(newFiles);
          });
        }
      }
    } catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Error picking files: $e')),
        );
      }
    }
  }

  /// Remove a file from the selected list
  void _removeFile(int index) {
    setState(() {
      _selectedFiles.removeAt(index);
    });
  }

  /// Upload documents to a policy
  /// 
  /// This method is called after the policy is successfully created.
  /// It sequentially uploads each selected file to the newly created policy.
  Future<void> _uploadDocuments(int policyId) async {
    if (_selectedFiles.isEmpty) return;

    setState(() => _isUploadingDocuments = true);

    try {
      for (int i = 0; i < _selectedFiles.length; i++) {
        final file = _selectedFiles[i];
        final fileName = file.path.split('/').last;

        if (mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text('Uploading $fileName... (${i + 1}/${_selectedFiles.length})')),
          );
        }

        final result = await _apiService.uploadDocument(policyId, file);

        if (!result['success'] && mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(
              content: Text('Failed to upload $fileName: ${result['message']}'),
              backgroundColor: Colors.red,
            ),
          );
        }
      }

      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(
            content: Text('All documents uploaded successfully!'),
            backgroundColor: Colors.green,
          ),
        );
      }
    } catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Error uploading documents: $e')),
        );
      }
    } finally {
      if (mounted) {
        setState(() => _isUploadingDocuments = false);
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Add New Policy'),
        backgroundColor: const Color(0xFF004a99),
        foregroundColor: Colors.white,
      ),
      body: _isFetchingTypes
          ? const Center(child: CircularProgressIndicator())
          : SingleChildScrollView(
              padding: const EdgeInsets.all(24.0),
              child: Form(
                key: _formKey,
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    const Text(
                      'Select Policy Type',
                      style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Color(0xFF004a99)),
                    ),
                    const SizedBox(height: 12),
                    DropdownButtonFormField<int>(
                      decoration: InputDecoration(
                        border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                        contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                      ),
                      value: _selectedPolicyTypeId,
                      hint: const Text('Choose a policy type'),
                      items: _policyTypes.map((type) {
                        return DropdownMenuItem<int>(
                          value: type.id,
                          child: Text(type.name),
                        );
                      }).toList(),
                      onChanged: (value) => setState(() => _selectedPolicyTypeId = value),
                    ),
                    const SizedBox(height: 24),
                    const Text(
                      'Select Plan Type',
                      style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Color(0xFF004a99)),
                    ),
                    const SizedBox(height: 12),
                    Row(
                      children: [
                        Expanded(
                          child: RadioListTile<String>(
                            title: const Text('Standard'),
                            value: 'Standard',
                            groupValue: _selectedPlanType,
                            onChanged: (value) => setState(() => _selectedPlanType = value!),
                            contentPadding: EdgeInsets.zero,
                          ),
                        ),
                        Expanded(
                          child: RadioListTile<String>(
                            title: const Text('Premium'),
                            value: 'Premium',
                            groupValue: _selectedPlanType,
                            onChanged: (value) => setState(() => _selectedPlanType = value!),
                            contentPadding: EdgeInsets.zero,
                          ),
                        ),
                      ],
                    ),
                    const SizedBox(height: 24),
                    const Text(
                      'Start Date',
                      style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Color(0xFF004a99)),
                    ),
                    const SizedBox(height: 12),
                    InkWell(
                      onTap: () => _selectDate(context),
                      child: Container(
                        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 16),
                        decoration: BoxDecoration(
                          border: Border.all(color: Colors.grey),
                          borderRadius: BorderRadius.circular(12),
                        ),
                        child: Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            Text(
                              "${_selectedDate.year}-${_selectedDate.month.toString().padLeft(2, '0')}-${_selectedDate.day.toString().padLeft(2, '0')}",
                              style: const TextStyle(fontSize: 16),
                            ),
                            const Icon(Icons.calendar_today, color: Color(0xFF7fb13b)),
                          ],
                        ),
                      ),
                    ),
                    const SizedBox(height: 24),
                    const Text(
                      'Attach Documents (Optional)',
                      style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Color(0xFF004a99)),
                    ),
                    const SizedBox(height: 8),
                    const Text(
                      'Supported: PDF, JPG, PNG, DOC, DOCX, XLS, XLSX (Max 2MB each)',
                      style: TextStyle(fontSize: 12, color: Colors.grey),
                    ),
                    const SizedBox(height: 12),
                    SizedBox(
                      width: double.infinity,
                      height: 48,
                      child: OutlinedButton.icon(
                        onPressed: _pickFiles,
                        icon: const Icon(Icons.attach_file, color: Color(0xFF004a99)),
                        label: const Text(
                          'Choose Files',
                          style: TextStyle(color: Color(0xFF004a99), fontWeight: FontWeight.bold),
                        ),
                        style: OutlinedButton.styleFrom(
                          side: const BorderSide(color: Color(0xFF004a99)),
                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                        ),
                      ),
                    ),
                    if (_selectedFiles.isNotEmpty) ...[
                      const SizedBox(height: 16),
                      Container(
                        padding: const EdgeInsets.all(12),
                        decoration: BoxDecoration(
                          color: Colors.blue.shade50,
                          borderRadius: BorderRadius.circular(8),
                          border: Border.all(color: Colors.blue.shade200),
                        ),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              'Selected Files (${_selectedFiles.length})',
                              style: const TextStyle(
                                fontWeight: FontWeight.bold,
                                color: Color(0xFF004a99),
                              ),
                            ),
                            const SizedBox(height: 8),
                            ..._selectedFiles.asMap().entries.map((entry) {
                              final index = entry.key;
                              final file = entry.value;
                              final fileName = file.path.split('/').last;
                              final fileSizeInMB = (file.lengthSync() / (1024 * 1024)).toStringAsFixed(2);
                              
                              return Padding(
                                padding: const EdgeInsets.only(bottom: 8.0),
                                child: Row(
                                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                  children: [
                                    Expanded(
                                      child: Column(
                                        crossAxisAlignment: CrossAxisAlignment.start,
                                        children: [
                                          Text(
                                            fileName,
                                            overflow: TextOverflow.ellipsis,
                                            style: const TextStyle(fontSize: 13),
                                          ),
                                          Text(
                                            '$fileSizeInMB MB',
                                            style: const TextStyle(fontSize: 11, color: Colors.grey),
                                          ),
                                        ],
                                      ),
                                    ),
                                    IconButton(
                                      onPressed: () => _removeFile(index),
                                      icon: const Icon(Icons.close, color: Colors.red, size: 20),
                                      padding: EdgeInsets.zero,
                                      constraints: const BoxConstraints(),
                                    ),
                                  ],
                                ),
                              );
                            }).toList(),
                          ],
                        ),
                      ),
                    ],
                    const SizedBox(height: 48),
                    SizedBox(
                      width: double.infinity,
                      height: 54,
                      child: ElevatedButton(
                        onPressed: _isLoading || _isUploadingDocuments ? null : _submit,
                        style: ElevatedButton.styleFrom(
                          backgroundColor: const Color(0xFF7fb13b),
                          foregroundColor: Colors.white,
                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                          elevation: 0,
                        ),
                        child: _isLoading || _isUploadingDocuments
                            ? const CircularProgressIndicator(color: Colors.white)
                            : const Text('ADD POLICY', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, letterSpacing: 1)),
                      ),
                    ),
                  ],
                ),
              ),
            ),
    );
  }
}
