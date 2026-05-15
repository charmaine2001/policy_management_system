import 'package:flutter/material.dart';
import 'api_service.dart';
import 'models.dart';
import 'policy_details_page.dart';
import 'query_page.dart';
import 'login_page.dart';

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  final ApiService _apiService = ApiService();
  int _selectedIndex = 0;
  String? _userName;

  @override
  void initState() {
    super.initState();
    _loadUser();
  }

  void _loadUser() async {
    final name = await _apiService.getUserName();
    setState(() {
      _userName = name;
    });
  }

  static const List<String> _titles = [
    'My Policies',
    'Renewal Dates',
    'Documents',
    'Queries',
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey[50],
      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0,
        centerTitle: true,
        leading: Builder(
          builder: (context) => IconButton(
            icon: const Icon(Icons.menu_rounded, color: Color(0xFF004a99), size: 28),
            onPressed: () => Scaffold.of(context).openDrawer(),
          ),
        ),
        title: Column(
          children: [
            Text(
              _titles[_selectedIndex].toUpperCase(),
              style: const TextStyle(color: Color(0xFF004a99), fontSize: 16, fontWeight: FontWeight.w900, letterSpacing: 1),
            ),
            if (_userName != null)
              Text(
                'Welcome, $_userName',
                style: TextStyle(color: Colors.grey[600], fontSize: 10, fontWeight: FontWeight.bold, letterSpacing: 0.5),
              ),
          ],
        ),
        actions: [
          Padding(
            padding: const EdgeInsets.only(right: 8.0),
            child: IconButton(
              icon: const Icon(Icons.notifications_none_rounded, color: Color(0xFF7fb13b)),
              onPressed: () {},
            ),
          ),
        ],
        bottom: PreferredSize(
          preferredSize: const Size.fromHeight(1),
          child: Container(color: Colors.grey[200], height: 1),
        ),
      ),
      drawer: Drawer(
        elevation: 0,
        child: Column(
          children: [
            Container(
              padding: const EdgeInsets.fromLTRB(24, 60, 24, 32),
              width: double.infinity,
              decoration: const BoxDecoration(
                color: Color(0xFF004a99),
                borderRadius: BorderRadius.only(bottomRight: Radius.circular(40)),
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Container(
                    padding: const EdgeInsets.all(3),
                    decoration: const BoxDecoration(color: Colors.white, shape: BoxShape.circle),
                    child: CircleAvatar(
                      backgroundColor: const Color(0xFF7fb13b),
                      radius: 35,
                      child: Text(
                        _userName != null ? _userName!.substring(0, 1).toUpperCase() : 'C',
                        style: const TextStyle(color: Colors.white, fontSize: 32, fontWeight: FontWeight.w900),
                      ),
                    ),
                  ),
                  const SizedBox(height: 16),
                  Text(
                    _userName ?? 'Valued Client',
                    style: const TextStyle(color: Colors.white, fontSize: 20, fontWeight: FontWeight.w900),
                  ),
                  const Text(
                    'Zimnat Policy Holder',
                    style: TextStyle(color: Colors.white70, fontSize: 12, fontWeight: FontWeight.bold, letterSpacing: 0.5),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 24),
            _buildDrawerItem(0, Icons.dashboard_rounded, 'Dashboard'),
            _buildDrawerItem(1, Icons.calendar_today_rounded, 'Renewals'),
            _buildDrawerItem(2, Icons.folder_open_rounded, 'Documents'),
            _buildDrawerItem(3, Icons.chat_bubble_outline_rounded, 'Queries'),
            const Spacer(),
            const Divider(indent: 24, endIndent: 24),
            ListTile(
              contentPadding: const EdgeInsets.symmetric(horizontal: 32, vertical: 8),
              leading: const Icon(Icons.logout_rounded, color: Colors.redAccent),
              title: const Text('LOGOUT', style: TextStyle(color: Colors.redAccent, fontWeight: FontWeight.w900, fontSize: 12, letterSpacing: 1)),
              onTap: () async {
                await _apiService.logout();
                if (mounted) {
                  Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(builder: (context) => const LoginPage()),
                  );
                }
              },
            ),
            const SizedBox(height: 32),
          ],
        ),
      ),
      body: Container(
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: const BorderRadius.only(topLeft: Radius.circular(30), topRight: Radius.circular(30)),
          boxShadow: [
            BoxShadow(color: Colors.black.withOpacity(0.03), blurRadius: 20, offset: const Offset(0, -10)),
          ],
        ),
        child: ClipRRect(
          borderRadius: const BorderRadius.only(topLeft: Radius.circular(30), topRight: Radius.circular(30)),
          child: _buildBody(),
        ),
      ),
      bottomNavigationBar: Container(
        decoration: BoxDecoration(
          color: Colors.white,
          boxShadow: [
            BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 10, offset: const Offset(0, -5)),
          ],
        ),
        child: SafeArea(
          child: Padding(
            padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 8),
            child: BottomNavigationBar(
              currentIndex: _selectedIndex,
              elevation: 0,
              backgroundColor: Colors.transparent,
              type: BottomNavigationBarType.fixed,
              selectedItemColor: const Color(0xFF004a99),
              unselectedItemColor: Colors.grey[400],
              selectedLabelStyle: const TextStyle(fontWeight: FontWeight.w900, fontSize: 10, letterSpacing: 0.5),
              unselectedLabelStyle: const TextStyle(fontWeight: FontWeight.bold, fontSize: 10),
              items: const [
                BottomNavigationBarItem(icon: Icon(Icons.home_rounded), label: 'HOME'),
                BottomNavigationBarItem(icon: Icon(Icons.event_note_rounded), label: 'RENEWALS'),
                BottomNavigationBarItem(icon: Icon(Icons.description_rounded), label: 'DOCS'),
                BottomNavigationBarItem(icon: Icon(Icons.message_rounded), label: 'QUERIES'),
              ],
              onTap: (index) => setState(() => _selectedIndex = index),
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildDrawerItem(int index, IconData icon, String title) {
    bool isSelected = _selectedIndex == index;
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 4),
      child: ListTile(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
        tileColor: isSelected ? const Color(0xFF7fb13b).withOpacity(0.1) : Colors.transparent,
        leading: Icon(icon, color: isSelected ? const Color(0xFF7fb13b) : const Color(0xFF004a99)),
        title: Text(
          title.toUpperCase(),
          style: TextStyle(
            color: isSelected ? const Color(0xFF7fb13b) : const Color(0xFF004a99),
            fontWeight: isSelected ? FontWeight.w900 : FontWeight.bold,
            fontSize: 12,
            letterSpacing: 1,
          ),
        ),
        onTap: () {
          setState(() => _selectedIndex = index);
          Navigator.pop(context);
        },
      ),
    );
  }

  Widget _buildBody() {
    switch (_selectedIndex) {
      case 0:
        return _PoliciesList(apiService: _apiService, mode: 'all');
      case 1:
        return _PoliciesList(apiService: _apiService, mode: 'renewals');
      case 2:
        return _PoliciesList(apiService: _apiService, mode: 'documents');
      case 3:
        return const QueryPage();
      default:
        return const Center(child: Text('Coming Soon'));
    }
  }
}

class _PoliciesList extends StatefulWidget {
  final ApiService apiService;
  final String mode;
  const _PoliciesList({required this.apiService, required this.mode});

  @override
  State<_PoliciesList> createState() => _PoliciesListState();
}

class _PoliciesListState extends State<_PoliciesList> {
  late Future<List<Policy>> _policiesFuture;

  @override
  void initState() {
    super.initState();
    _policiesFuture = widget.apiService.getPolicies();
  }

  @override
  Widget build(BuildContext context) {
    return FutureBuilder<List<Policy>>(
      future: _policiesFuture,
      builder: (context, snapshot) {
        if (snapshot.connectionState == ConnectionState.waiting) {
          return const Center(child: CircularProgressIndicator());
        } else if (snapshot.hasError) {
          return Center(child: Text('Error: ${snapshot.error}'));
        } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
          return const Center(child: Text('No records found.'));
        }

        final policies = snapshot.data!;
        
        return ListView.builder(
          itemCount: policies.length,
          itemBuilder: (context, index) {
            final policy = policies[index];
            
            if (widget.mode == 'documents' && (policy.documents == null || policy.documents!.isEmpty)) {
               // If searching for docs but none exist, we still show the policy but maybe highlighted differently
               // Or we can filter them out if we want
            }

            return Card(
              margin: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
              elevation: 4,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(12),
                side: BorderSide(color: const Color(0xFF7fb13b).withOpacity(0.3), width: 1),
              ),
              child: ListTile(
                contentPadding: const EdgeInsets.all(16),
                title: Text(
                  policy.policyNumber,
                  style: const TextStyle(fontWeight: FontWeight.bold, color: Color(0xFF004a99)),
                ),
                subtitle: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text('${policy.insuranceType}', style: const TextStyle(fontWeight: FontWeight.bold)),
                    const SizedBox(height: 4),
                    if (widget.mode == 'renewals')
                      Text('Renewal: ${policy.renewalDate}', style: const TextStyle(color: Colors.orange, fontWeight: FontWeight.bold))
                    else
                      Text('Renewal: ${policy.renewalDate}'),
                  ],
                ),
                trailing: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Container(
                      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                      decoration: BoxDecoration(
                        color: policy.status == 'Active' ? const Color(0xFF7fb13b) : Colors.red,
                        borderRadius: BorderRadius.circular(12),
                      ),
                      child: Text(
                        policy.status,
                        style: const TextStyle(color: Colors.white, fontSize: 10, fontWeight: FontWeight.bold),
                      ),
                    ),
                    if (widget.mode == 'documents')
                      const Padding(
                        padding: EdgeInsets.only(top: 8.0),
                        child: Icon(Icons.attach_file, size: 16, color: Colors.grey),
                      ),
                  ],
                ),
                onTap: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (context) => PolicyDetailsPage(policyId: policy.id),
                    ),
                  );
                },
              ),
            );
          },
        );
      },
    );
  }
}
