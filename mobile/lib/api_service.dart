import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'models.dart';

import 'package:flutter/foundation.dart';
import 'dart:io';

class ApiService {
  // Use 192.168.100.224 for physical iPhone on the same Wi-Fi
  // Use localhost for macOS desktop app or iOS simulator
  static String get siteUrl {
    // Use the Mac's local IP address so both macOS and iPhone can connect
    return 'http://192.168.100.224:8001';
  }

  static String get baseUrl => '$siteUrl/api';

  Future<String?> getToken() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('token');
  }

  Future<Map<String, String>> _getHeaders() async {
    final token = await getToken();
    return {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      if (token != null) 'Authorization': 'Bearer $token',
    };
  }

  Future<bool> login(String email, String password) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/login'),
        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
        body: jsonEncode({
          'email': email,
          'password': password,
          'device_name': 'mobile_app',
        }),
      );

      print('Login Status Code: ${response.statusCode}');
      print('Login Response Body: ${response.body}');

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        final prefs = await SharedPreferences.getInstance();
        await prefs.setString('token', data['token']);
        await prefs.setString('user_name', data['user']['name']);
        return true;
      }
      return false;
    } catch (e) {
      print('Login Error: $e');
      return false;
    }
  }

  Future<String?> getUserName() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('user_name');
  }

  Future<List<Policy>> getPolicies() async {
    final response = await http.get(
      Uri.parse('$baseUrl/policies'),
      headers: await _getHeaders(),
    );

    if (response.statusCode == 200) {
      List jsonResponse = jsonDecode(response.body);
      return jsonResponse.map((p) => Policy.fromJson(p)).toList();
    } else {
      throw Exception('Failed to load policies: ${response.statusCode} - ${response.body}');
    }
  }

  Future<Policy> getPolicyDetails(int id) async {
    final response = await http.get(
      Uri.parse('$baseUrl/policies/$id'),
      headers: await _getHeaders(),
    );

    if (response.statusCode == 200) {
      return Policy.fromJson(jsonDecode(response.body));
    } else {
      throw Exception('Failed to load policy details: ${response.statusCode}');
    }
  }

  Future<List<QueryIssue>> getQueries() async {
    final response = await http.get(
      Uri.parse('$baseUrl/queries'),
      headers: await _getHeaders(),
    );

    if (response.statusCode == 200) {
      List jsonResponse = jsonDecode(response.body);
      return jsonResponse.map((q) => QueryIssue.fromJson(q)).toList();
    } else {
      throw Exception('Failed to load queries: ${response.statusCode}');
    }
  }

  Future<bool> raiseQuery(String subject, String message) async {
    final response = await http.post(
      Uri.parse('$baseUrl/queries'),
      headers: await _getHeaders(),
      body: jsonEncode({
        'subject': subject,
        'message': message,
      }),
    );

    return response.statusCode == 201;
  }

  Future<void> logout() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('token');
  }
}
