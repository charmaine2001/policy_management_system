import 'package:flutter/material.dart';
import 'api_service.dart';
import 'models.dart';

class QueryPage extends StatefulWidget {
  final bool showAppBar;
  const QueryPage({super.key, this.showAppBar = false});

  @override
  State<QueryPage> createState() => _QueryPageState();
}

class _QueryPageState extends State<QueryPage> {
  final ApiService _apiService = ApiService();
  late Future<List<QueryIssue>> _queriesFuture;
  final _subjectController = TextEditingController();
  final _messageController = TextEditingController();

  @override
  void initState() {
    super.initState();
    _refreshQueries();
  }

  void _refreshQueries() {
    setState(() {
      _queriesFuture = _apiService.getQueries();
    });
  }

  void _showRaiseQueryDialog() {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Raise a Query', style: TextStyle(color: Color(0xFF004a99), fontWeight: FontWeight.bold, fontStyle: FontStyle.italic)),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            TextField(
              controller: _subjectController, 
              decoration: const InputDecoration(
                labelText: 'Subject',
                labelStyle: TextStyle(color: Color(0xFF004a99)),
                focusedBorder: UnderlineInputBorder(borderSide: BorderSide(color: Color(0xFF7fb13b))),
              )
            ),
            const SizedBox(height: 10),
            TextField(
              controller: _messageController, 
              decoration: const InputDecoration(
                labelText: 'Message',
                labelStyle: TextStyle(color: Color(0xFF004a99)),
                focusedBorder: UnderlineInputBorder(borderSide: BorderSide(color: Color(0xFF7fb13b))),
              ), 
              maxLines: 3
            ),
          ],
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context), 
            child: const Text('Cancel', style: TextStyle(color: Colors.grey))
          ),
          ElevatedButton(
            style: ElevatedButton.styleFrom(backgroundColor: const Color(0xFF7fb13b), foregroundColor: Colors.white),
            onPressed: () async {
              if (_subjectController.text.isEmpty || _messageController.text.isEmpty) {
                 ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Please fill all fields')));
                 return;
              }
              final success = await _apiService.raiseQuery(_subjectController.text, _messageController.text);
              if (mounted) {
                Navigator.pop(context);
                if (success) {
                  _refreshQueries();
                  _subjectController.clear();
                  _messageController.clear();
                  ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Query submitted successfully')));
                }
              }
            },
            child: const Text('Submit', style: TextStyle(fontWeight: FontWeight.bold, fontStyle: FontStyle.italic)),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    Widget body = FutureBuilder<List<QueryIssue>>(
      future: _queriesFuture,
      builder: (context, snapshot) {
        if (snapshot.connectionState == ConnectionState.waiting) {
          return const Center(child: CircularProgressIndicator(color: Color(0xFF7fb13b)));
        } else if (snapshot.hasError) {
          return Center(child: Text('Error: ${snapshot.error}', style: const TextStyle(color: Colors.red)));
        } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
          return Center(
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Icon(Icons.chat_bubble_outline_rounded, size: 64, color: Colors.grey[300]),
                const SizedBox(height: 16),
                Text('No queries found', style: TextStyle(color: Colors.grey[400], fontWeight: FontWeight.bold)),
              ],
            ),
          );
        }

        return ListView.builder(
          padding: const EdgeInsets.fromLTRB(16, 24, 16, 100),
          itemCount: snapshot.data!.length,
          itemBuilder: (context, index) {
            final query = snapshot.data![index];
            bool isResolved = query.status == 'Resolved';
            return Container(
              margin: const EdgeInsets.only(bottom: 20),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(24),
                border: Border.all(color: Colors.grey[100]!),
                boxShadow: [
                  BoxShadow(color: Colors.black.withOpacity(0.02), blurRadius: 10, offset: const Offset(0, 4)),
                ],
              ),
              child: ExpansionTile(
                tilePadding: const EdgeInsets.symmetric(horizontal: 20, vertical: 8),
                childrenPadding: const EdgeInsets.fromLTRB(20, 0, 20, 20),
                shape: const RoundedRectangleBorder(borderRadius: BorderRadius.all(Radius.circular(24))),
                collapsedShape: const RoundedRectangleBorder(borderRadius: BorderRadius.all(Radius.circular(24))),
                title: Text(
                  query.subject.toUpperCase(),
                  style: const TextStyle(fontWeight: FontWeight.w900, color: Color(0xFF004a99), fontSize: 13, letterSpacing: 0.5),
                ),
                subtitle: Padding(
                  padding: const EdgeInsets.only(top: 8.0),
                  child: Row(
                    children: [
                      Container(
                        padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                        decoration: BoxDecoration(
                          color: _getStatusColor(query.status).withOpacity(0.1),
                          borderRadius: BorderRadius.circular(10),
                        ),
                        child: Row(
                          children: [
                            Container(
                              width: 6,
                              height: 6,
                              decoration: BoxDecoration(color: _getStatusColor(query.status), shape: BoxShape.circle),
                            ),
                            const SizedBox(width: 6),
                            Text(
                              query.status.toUpperCase(), 
                              style: TextStyle(fontSize: 9, fontWeight: FontWeight.w900, color: _getStatusColor(query.status), letterSpacing: 0.5)
                            ),
                          ],
                        ),
                      ),
                      const SizedBox(width: 12),
                      Text(
                        query.createdAt.substring(0, 10),
                        style: TextStyle(fontSize: 10, fontWeight: FontWeight.bold, color: Colors.grey[400]),
                      ),
                    ],
                  ),
                ),
                leading: Container(
                  width: 44,
                  height: 44,
                  decoration: BoxDecoration(
                    color: _getStatusColor(query.status).withOpacity(0.1),
                    borderRadius: BorderRadius.circular(14),
                  ),
                  child: Icon(
                    isResolved ? Icons.check_circle_outline_rounded : Icons.help_outline_rounded, 
                    color: _getStatusColor(query.status),
                    size: 22,
                  ),
                ),
                children: [
                  const Divider(height: 1),
                  const SizedBox(height: 20),
                  const Text('YOUR MESSAGE', style: TextStyle(fontWeight: FontWeight.w900, color: Colors.grey, fontSize: 10, letterSpacing: 1)),
                  const SizedBox(height: 8),
                  Text(query.message, style: const TextStyle(color: Color(0xFF004a99), fontWeight: FontWeight.w500)),
                  if (query.response != null) ...[
                    const SizedBox(height: 24),
                    const Text('OFFICIAL RESPONSE', style: TextStyle(fontWeight: FontWeight.w900, color: Color(0xFF7fb13b), fontSize: 10, letterSpacing: 1)),
                    const SizedBox(height: 8),
                    Container(
                      width: double.infinity,
                      padding: const EdgeInsets.all(16),
                      decoration: BoxDecoration(
                        color: const Color(0xFF7fb13b).withOpacity(0.05),
                        borderRadius: BorderRadius.circular(16),
                        border: Border.all(color: const Color(0xFF7fb13b).withOpacity(0.1)),
                      ),
                      child: Text(
                        query.response!,
                        style: const TextStyle(color: Color(0xFF004a99), fontWeight: FontWeight.bold, height: 1.5),
                      ),
                    ),
                  ] else ...[
                    const SizedBox(height: 24),
                    Container(
                      padding: const EdgeInsets.all(12),
                      decoration: BoxDecoration(
                        color: Colors.orange.withOpacity(0.05),
                        borderRadius: BorderRadius.circular(12),
                      ),
                      child: const Row(
                        children: [
                          Icon(Icons.access_time_rounded, size: 14, color: Colors.orange),
                          SizedBox(width: 8),
                          Text(
                            'PENDING REVIEW BY STAFF', 
                            style: TextStyle(fontWeight: FontWeight.w900, color: Colors.orange, fontSize: 9, letterSpacing: 0.5)
                          ),
                        ],
                      ),
                    ),
                  ],
                ],
              ),
            );
          },
        );
      },
    );

    if (widget.showAppBar) {
      return Scaffold(
        appBar: AppBar(title: const Text('My Queries')),
        body: body,
        floatingActionButton: FloatingActionButton(
          onPressed: _showRaiseQueryDialog,
          backgroundColor: const Color(0xFF7fb13b),
          foregroundColor: Colors.white,
          child: const Icon(Icons.add_comment),
        ),
      );
    }

    return Scaffold(
      body: body,
      floatingActionButton: FloatingActionButton(
        onPressed: _showRaiseQueryDialog,
        backgroundColor: const Color(0xFF7fb13b),
        foregroundColor: Colors.white,
        child: const Icon(Icons.add_comment),
      ),
    );
  }

  Color _getStatusColor(String status) {
    switch (status) {
      case 'Resolved': return Colors.green;
      case 'In Progress': return Colors.orange;
      case 'Open': return Colors.red;
      default: return Colors.grey;
    }
  }
}
