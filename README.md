# Quetzal
Code for the official Pterodactyl FQDN generation service.

## Getting Started
1. Clone the application using Git to a web server. Make sure to enable [Pretty URLs](https://laravel.com/docs/5.1#configuration) in your web server config.
2. Rename `.env.sample` to `.env`. Generate an application key, as well as fill in your Cloudflare Email, API Key, and Domain you'd like to use to create sub-domains. If you'd like to disable the API or Frontend, the set those values to **true** or **false** respectively.
3. In `resources/lang/en/base.php`, fill in a Terms of Use in the `TOS` array. Also set the help and/or home URLs. Adjust any templates if prefered. You can also modify the description of the application as well.
4. You are all set! Enjoy your fancy new public subdomain creator.

## API Documentation
The Quetzal API is very simple and does not require any authentication.
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
