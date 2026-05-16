class User {
  final int id;
  final String name;
  final String email;
  final String role;

  User({required this.id, required this.name, required this.email, required this.role});

  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['id'],
      name: json['name'],
      email: json['email'],
      role: json['role'],
    );
  }
}

class Policy {
  final int id;
  final String policyNumber;
  final String insuranceType;
  final double premiumAmount;
  final String startDate;
  final String renewalDate;
  final String status;
  final String? planType;
  final int? policyTypeId;
  final List<Document>? documents;

  Policy({
    required this.id,
    required this.policyNumber,
    required this.insuranceType,
    required this.premiumAmount,
    required this.startDate,
    required this.renewalDate,
    required this.status,
    this.planType,
    this.policyTypeId,
    this.documents,
  });

  factory Policy.fromJson(Map<String, dynamic> json) {
    return Policy(
      id: json['id'],
      policyNumber: json['policy_number'],
      insuranceType: json['insurance_type'] ?? '',
      premiumAmount: double.parse((json['premium_amount'] ?? json['final_price'] ?? 0).toString()),
      startDate: json['start_date'],
      renewalDate: json['renewal_date'],
      status: json['status'],
      planType: json['plan_type'],
      policyTypeId: json['policy_type_id'],
      documents: json['documents'] != null 
        ? (json['documents'] as List).map((i) => Document.fromJson(i)).toList()
        : null,
    );
  }
}

class PolicyType {
  final int id;
  final String name;
  final double standardPrice;
  final double premiumPrice;

  PolicyType({
    required this.id, 
    required this.name, 
    required this.standardPrice,
    required this.premiumPrice,
  });

  factory PolicyType.fromJson(Map<String, dynamic> json) {
    return PolicyType(
      id: json['id'],
      name: json['name'],
      standardPrice: double.parse((json['standard_price'] ?? 0).toString()),
      premiumPrice: double.parse((json['premium_price'] ?? 0).toString()),
    );
  }
}

class Document {
  final int id;
  final String fileName;
  final String filePath;
  final String fileType;

  Document({required this.id, required this.fileName, required this.filePath, required this.fileType});

  factory Document.fromJson(Map<String, dynamic> json) {
    return Document(
      id: json['id'],
      fileName: json['file_name'],
      filePath: json['file_path'],
      fileType: json['file_type'],
    );
  }
}

class QueryIssue {
  final int id;
  final String subject;
  final String message;
  final String? response;
  final String status;
  final String createdAt;

  QueryIssue({
    required this.id,
    required this.subject,
    required this.message,
    this.response,
    required this.status,
    required this.createdAt,
  });

  factory QueryIssue.fromJson(Map<String, dynamic> json) {
    return QueryIssue(
      id: json['id'],
      subject: json['subject'],
      message: json['message'],
      response: json['response'],
      status: json['status'],
      createdAt: json['created_at'],
    );
  }
}
