# PHP Mini Event Booking App
 Lab 02 PHP

 ## Run
 php -S localhost:8000 -t public

 ## Endpoint
 - GET /
- GET /events
- HEAD /events
- POST /registrations
- OPTIONS /registrations
- GET /health

## API Test Instructions:
- 200 OK: curl.exe -I http://localhost:8000/events
- 201 Created: curl.exe --% -i -X POST http://localhost:8000/registrations -H "Content-Type: application/json" -d"{\"register_name\":\"Joshua\",\"email\":\"hsj3012@gmail.com\",\"phone_number\":\"0912345678\",\"event_id\":1,\"quantity\":1}"
- 404 Not Found: curl.exe --% -i -X GET http://localhost:8000/even        
- 405 Method Not Allowed: curl.exe -i -X PUT http://localhost:8000/registrations
- 415 Unsupported Media Type: curl.exe --% -i -X POST http://localhost:8000/registrations -H "Content-Type: text/plain" -d'hello'
- 422 Unprocessable Content: curl.exe --% -i -X POST http://localhost:8000/registrations -H "Content-Type: application/json" -d "{\"event_id\":1, \"register_name\":\"\", \"email\":\"hsj3012@gmail.com\", \"phone_number\":\"\", \"quantity\":1}"