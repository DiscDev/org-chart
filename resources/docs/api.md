## API Documentation

### Authentication

All API endpoints require authentication using Laravel Sanctum. Include the bearer token in the Authorization header:

```
Authorization: Bearer <your-token>
```

### Response Format

All responses follow this standard format:

```json
{
    "success": true|false,
    "message": "Response message",
    "data": { ... }
}
```

### Error Handling

Errors return with appropriate HTTP status codes and this format:

```json
{
    "success": false,
    "message": "Error message",
    "errors": { ... }
}
```

### Rate Limiting

API requests are limited to 60 per minute per user/IP. Headers include:
- `X-RateLimit-Limit`: Maximum requests per minute
- `X-RateLimit-Remaining`: Remaining requests

### Endpoints

#### Users

##### List Users
```
GET /api/v1/users
```

Query Parameters:
- `search`: Search by username, name, or email
- `department_id`: Filter by department
- `team_id`: Filter by team
- `role_id`: Filter by role
- `office_id`: Filter by office
- `agency_id`: Filter by agency
- `per_page`: Results per page (default: 15)

Response:
```json
{
    "success": true,
    "data": {
        "data": [
            {
                "id": 1,
                "username": "john.doe",
                "email_work": "john.doe@spikeup.com",
                "first_name": "John",
                "last_name": "Doe",
                "full_name": "John Doe",
                "job_title": "Developer",
                "departments": ["Development"],
                "teams": ["Bankrolls.com"],
                "roles": ["Full Stack Developer"],
                "offices": ["Remote"],
                "agency": "SpikeUp"
            }
        ],
        "meta": {
            "current_page": 1,
            "total": 50,
            "per_page": 15
        }
    }
}
```

##### Get User
```
GET /api/v1/users/{id}
```

Response includes all user details and relationships.

##### Create User
```
POST /api/v1/users
```

Required fields:
- `username`
- `email_work`
- `email_personal`
- `password`
- `first_name`
- `last_name`
- `start_date`
- `job_title`
- `timezone_id`
- `location`
- `agency_id`
- `user_type_id`

Optional arrays:
- `departments[]`
- `teams[]`
- `roles[]`
- `offices[]`

##### Update User
```
PUT /api/v1/users/{id}
```

All fields are optional for updates.

##### Delete User
```
DELETE /api/v1/users/{id}
```

##### Get User's Subordinates
```
GET /api/v1/users/{id}/subordinates
```

##### Get User's Manager
```
GET /api/v1/users/{id}/manager
```

#### Organization Chart

##### Get Full Org Chart
```
GET /api/v1/org-chart
```

Response:
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "John Doe",
            "title": "CEO",
            "departments": ["Executive"],
            "teams": ["Leadership"],
            "roles": ["Chief Executive Officer"],
            "children": [
                {
                    "id": 2,
                    "name": "Jane Smith",
                    "title": "CTO",
                    "children": []
                }
            ]
        }
    ]
}
```

##### Get Department Org Chart
```
GET /api/v1/org-chart/department/{id}
```

##### Get Team Org Chart
```
GET /api/v1/org-chart/team/{id}
```

#### Departments

##### List Departments
```
GET /api/v1/departments
```

##### Get Department
```
GET /api/v1/departments/{id}
```

##### Get Department Members
```
GET /api/v1/departments/{id}/members
```

Similar endpoints exist for Teams, Roles, Agencies, and Offices.

### Export Endpoints

#### Department Costs Report
```
GET /api/v1/reports/department-costs/export
```

Query Parameters:
- `period`: 3m|6m|12m|ytd
- `format`: xlsx|csv

#### Employee Directory
```
GET /api/v1/reports/employee-directory/export
```

Query Parameters:
- `format`: xlsx|csv

#### Turnover Report
```
GET /api/v1/reports/turnover/export
```

Query Parameters:
- `period`: 3m|6m|12m|ytd
- `group_by`: department|team|office
- `format`: xlsx|csv