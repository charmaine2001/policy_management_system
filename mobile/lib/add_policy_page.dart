import 'package:flutter/material.dart';
import 'api_service.dart';
import 'models.dart';

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
        Navigator.pop(context, true);
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
                    const SizedBox(height: 48),
                    SizedBox(
                      width: double.infinity,
                      height: 54,
                      child: ElevatedButton(
                        onPressed: _isLoading ? null : _submit,
                        style: ElevatedButton.styleFrom(
                          backgroundColor: const Color(0xFF7fb13b),
                          foregroundColor: Colors.white,
                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                          elevation: 0,
                        ),
                        child: _isLoading
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
