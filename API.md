# API Documentation (Future Enhancement)

## Overview

This document outlines potential API endpoints for the Outsinc AllInOne system. These are not yet implemented but serve as a roadmap for future mobile app or third-party integrations.

## Authentication

All API requests should include authentication via session tokens or API keys.

### Endpoint: POST /api/login
**Description:** Authenticate user and receive session token

**Request:**
```json
{
    "username": "string",
    "password": "string"
}
```

**Response:**
```json
{
    "success": true,
    "token": "session_token_here",
    "user": {
        "id": 1,
        "username": "admin",
        "email": "admin@example.com",
        "role": "admin",
        "status": "active"
    }
}
```

## User Management

### Endpoint: POST /api/users/register
**Description:** Register new client account (pending approval)

**Request:**
```json
{
    "username": "string",
    "email": "string",
    "password": "string",
    "full_name": "string"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Registration successful. Awaiting approval.",
    "user_id": 123
}
```

### Endpoint: GET /api/users
**Description:** Get list of users (Staff/Admin only)

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "users": [
        {
            "id": 1,
            "username": "admin",
            "email": "admin@example.com",
            "role": "admin",
            "status": "active",
            "created_at": "2024-01-01 00:00:00"
        }
    ]
}
```

### Endpoint: PUT /api/users/{id}/approve
**Description:** Approve pending user (Staff/Admin only)

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "message": "User approved successfully"
}
```

### Endpoint: POST /api/users/create
**Description:** Create staff/admin account (instant activation)

**Headers:**
```
Authorization: Bearer {token}
```

**Request:**
```json
{
    "username": "string",
    "email": "string",
    "password": "string",
    "full_name": "string",
    "role": "staff" | "admin"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Account created successfully",
    "user_id": 124
}
```

## Session Management

### Endpoint: POST /api/logout
**Description:** Logout and invalidate session

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "message": "Logged out successfully"
}
```

### Endpoint: GET /api/session/validate
**Description:** Validate current session

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "valid": true,
    "user": {
        "id": 1,
        "username": "admin",
        "role": "admin"
    }
}
```

## Error Responses

All endpoints may return error responses in this format:

```json
{
    "success": false,
    "error": {
        "code": "ERROR_CODE",
        "message": "Human readable error message"
    }
}
```

### Common Error Codes

- `INVALID_CREDENTIALS`: Invalid username or password
- `UNAUTHORIZED`: Not authorized to perform this action
- `USER_PENDING`: User account is pending approval
- `USER_INACTIVE`: User account is inactive
- `VALIDATION_ERROR`: Input validation failed
- `USER_EXISTS`: Username or email already exists
- `SESSION_EXPIRED`: Session token has expired
- `INVALID_TOKEN`: Invalid or missing session token

## Rate Limiting

Future API implementation should include rate limiting:
- 100 requests per minute per IP
- 1000 requests per hour per user

## Implementation Notes

To implement these APIs:

1. Create `/api` directory
2. Implement REST endpoints using PHP
3. Use JSON for request/response bodies
4. Implement proper CORS headers
5. Add rate limiting middleware
6. Add API key authentication alongside session tokens
7. Create comprehensive API tests

## Security Considerations

- All API endpoints must use HTTPS in production
- Implement rate limiting to prevent abuse
- Validate all input data
- Use prepared statements for database queries
- Implement proper authentication and authorization
- Log all API requests for auditing
- Implement CSRF protection for state-changing operations
- Use secure headers (HSTS, CSP, etc.)

## Future Enhancements

- WebSocket support for real-time notifications
- OAuth2 authentication
- API versioning (/api/v1/, /api/v2/)
- Swagger/OpenAPI documentation
- GraphQL endpoint as alternative to REST
- Webhook support for external integrations
