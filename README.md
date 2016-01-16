# Quetzal
Code for the official Pterodactyl FQDN generation service.

## Getting Started

## API Documentation
The Quetzal API is very simple and does not require any authentication. Rate limits can be adjusted in the `.env` file.
### POST /api/generate
**Parameters:** They are all required.

| Name  | Description |
| ------------- | ------------- |
| fqdn  | The prefix of the sub-domain that you would like to create. Examples: `coolnode` or `server1`  |
| ip | The IP that the new record should point to. Examples:  `1.1.1.1` or `172.16.254.1`|

**Success:**
```
{
  "success": 1,
  "message": "The record was created successfully.",
  "token": "2b4855ddbe6b8150923ead1bcc179757"
}
```
**Failure:**
```
{
  "success": 0,
  "message": "The fqdn has already been taken."
}
```

### DELETE /api/destroy
**Parameters:** They are all required.

| Name  | Description |
| ------------- | ------------- |
| token | The token of the record you'd like to delete. |

**Success:**
```
{
  "success": 1,
  "message": "The record was deleted successfully."
}
```
**Failure:**
```
{
  "success": 0,
  "message": "The selected token is invalid."
}
```
