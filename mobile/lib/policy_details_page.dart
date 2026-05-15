import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';
import 'api_service.dart';
import 'models.dart';

class PolicyDetailsPage extends StatefulWidget {
  final int policyId;
  const PolicyDetailsPage({super.key, required this.policyId});

  @override
  State<PolicyDetailsPage> createState() => _PolicyDetailsPageState();
}

class _PolicyDetailsPageState extends State<PolicyDetailsPage> {
  final ApiService _apiService = ApiService();
  late Future<Policy> _policyFuture;

  @override
  void initState() {
    super.initState();
    _policyFuture = _apiService.getPolicyDetails(widget.policyId);
  }

  Future<void> _launchURL(String url) async {
    final uri = Uri.parse(url);
    if (!await launchUrl(uri, mode: LaunchMode.externalApplication)) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Could not launch $url')),
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Policy Details')),
      body: FutureBuilder<Policy>(
        future: _policyFuture,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            return Center(child: Text('Error: ${snapshot.error}'));
          } else if (!snapshot.hasData) {
            return const Center(child: Text('Policy not found.'));
          }

          final policy = snapshot.data!;
          return SingleChildScrollView(
            padding: const EdgeInsets.all(16.0),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                _buildInfoCard(policy),
                const SizedBox(height: 24),
                const Row(
                  children: [
                    Icon(Icons.description, color: Color(0xFF004a99)),
                    SizedBox(width: 8),
                    Text('Documents', style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: Color(0xFF004a99))),
                  ],
                ),
                const Divider(color: Color(0xFF7fb13b), thickness: 2),
                const SizedBox(height: 8),
                if (policy.documents == null || policy.documents!.isEmpty)
                  const Center(
                    child: Padding(
                      padding: EdgeInsets.all(20.0),
                      child: Text('No documents available for this policy.', style: TextStyle(fontStyle: FontStyle.italic, color: Colors.grey)),
                    ),
                  )
                else
                  ListView.builder(
                    shrinkWrap: true,
                    physics: const NeverScrollableScrollPhysics(),
                    itemCount: policy.documents!.length,
                    itemBuilder: (context, index) {
                      final doc = policy.documents![index];
                      return Card(
                        margin: const EdgeInsets.only(bottom: 8),
                        child: ListTile(
                          leading: _getFileIcon(doc.fileType),
                          title: Text(doc.fileName, style: const TextStyle(fontWeight: FontWeight.bold)),
                          subtitle: Text(doc.fileType.toUpperCase(), style: const TextStyle(fontSize: 12)),
                          trailing: const Icon(Icons.open_in_new, color: Color(0xFF7fb13b)),
                          onTap: () {
                            // Construct full URL
                            // In Laravel, public files are in storage/
                            final url = '${ApiService.siteUrl}/storage/${doc.filePath}';
                            _launchURL(url);
                          },
                        ),
                      );
                    },
                  ),
              ],
            ),
          );
        },
      ),
    );
  }

  Widget _getFileIcon(String type) {
    switch (type.toLowerCase()) {
      case 'pdf': return const Icon(Icons.picture_as_pdf, color: Colors.red);
      case 'jpg':
      case 'jpeg':
      case 'png': return const Icon(Icons.image, color: Colors.blue);
      default: return const Icon(Icons.insert_drive_file, color: Colors.grey);
    }
  }

  Widget _buildInfoCard(Policy policy) {
    return Card(
      elevation: 4,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
        side: const BorderSide(color: Color(0xFF004a99), width: 1),
      ),
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: [
            _buildRow('Policy Number', policy.policyNumber, isTitle: true),
            const Divider(),
            _buildRow('Insurance Type', policy.insuranceType),
            _buildRow('Premium Amount', '\$${policy.premiumAmount.toStringAsFixed(2)}'),
            _buildRow('Start Date', policy.startDate),
            _buildRow('Renewal Date', policy.renewalDate, isBold: true, valueColor: Colors.orange),
            _buildRow('Status', policy.status, isStatus: true),
          ],
        ),
      ),
    );
  }

  Widget _buildRow(String label, String value, {bool isBold = false, bool isTitle = false, Color? valueColor, bool isStatus = false}) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 6.0),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(label, style: TextStyle(color: Colors.grey[700], fontWeight: isTitle ? FontWeight.bold : FontWeight.normal)),
          if (isStatus)
             Container(
                padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                decoration: BoxDecoration(
                  color: value == 'Active' ? const Color(0xFF7fb13b) : Colors.red,
                  borderRadius: BorderRadius.circular(12),
                ),
                child: Text(
                  value,
                  style: const TextStyle(color: Colors.white, fontSize: 12, fontWeight: FontWeight.bold),
                ),
              )
          else
            Text(
              value, 
              style: TextStyle(
                fontWeight: (isBold || isTitle) ? FontWeight.bold : FontWeight.normal,
                fontSize: isTitle ? 18 : 14,
                color: valueColor ?? (isTitle ? const Color(0xFF004a99) : Colors.black87)
              )
            ),
        ],
      ),
    );
  }
}
