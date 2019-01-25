# yii2-rest-api-example
Example using REST API

## Requirements
- [PHP] 7.1+
- [PostgreSQL] 9.6+

## Install
- git clone
- composer install
- php yii migrate

## Authorization
admin/admin

```rest
POST /v1/user/auth
```
Authorization

**Parameters:**

Name | Type | Mandatory | Description
------------ | ------------ | ------------ | ------------
auth[username] | STRING | YES | Username
auth[password] | STRING | YES | Password

**Response:**
```javascript
{
    "success": true,
    "status": 200,
    "data": {
        "jwt": "",
        "name": "Administrator"
    }
}
```

## File upload

```rest
POST /v1/file/upload
```
Upload file to server

**Parameters:**

Name | Type | Mandatory | Description
------------ | ------------ | ------------ | ------------
file | FILE | YES | 

**Response:**
```javascript
{
    "success": true,
    "status": 200,
    "data": {
        "uuid": "344178f3-d89d-4336-aed7-9108dd2f8362",
        "name": "test",
        "type": "application/pdf",
        "size": 284839,
        "created_at": "01.01.2019 14:15:59",
        "created_by": "Administrator"
    }
}
```

## File info

```rest
GET /v1/file/344178f3-d89d-4336-aed7-9108dd2f8362/info
```
File information

**Response:**
```javascript
{
    "success": true,
    "status": 200,
    "data": {
        "uuid": "344178f3-d89d-4336-aed7-9108dd2f8362",
        "name": "test",
        "type": "application/pdf",
        "size": 284839,
        "created_at": "01.01.2019 14:15:59",
        "created_by": "Administrator"
    }
}
```
