# IoT Cold Storage Monitoring System for Seafood

Real-time temperature and humidity monitoring system for seafood cold storage facilities, using RESTful API and visual web dashboard.

## Overview

This project provides an automated solution for monitoring environmental parameters in seafood cold storage warehouses, ensuring product quality and food safety compliance. The system alerts when parameters exceed safe thresholds.

## Key Features

- Monitor cold storage temperature (range: -22.5°C to -15.0°C)
- Track environmental humidity (80% - 99%)
- Automatic system status evaluation (Normal/Warning)
- Real-time data updates (every 2 seconds)
- REST API returning JSON-formatted data
- Visual dashboard interface
- Full Vietnamese language support (UTF-8)

## Project Structure

```
sensorhv/
├── api_sensor.php    # API endpoint providing sensor data
├── index.html        # Web monitoring dashboard
└── README.md         # Project documentation
```


## API Documentation

### Endpoint: GET /api_sensor.php

Returns current sensor data in JSON format.

#### Response Format

```json
{
  "sensor_id": "SN-THUYSAN-001",
  "location": "Kho-Dong-Lanh-A",
  "data": {
    "temperature": {
      "value": -18.5,
      "unit": "°C",
      "status": "Normal"
    },
    "humidity": {
      "value": 92,
      "unit": "%",
      "status": "Normal"
    }
  },
  "system_overall": "Normal",
  "timestamp": "2026-01-21 14:30:45"
}
```

#### Response Fields

| Field | Type | Description |
|-------|------|-------------|
| `sensor_id` | string | Sensor identifier |
| `location` | string | Sensor installation location |
| `data.temperature.value` | float | Current temperature value |
| `data.temperature.unit` | string | Unit of measurement (°C) |
| `data.temperature.status` | string | Status: "Normal" or "Warning" |
| `data.humidity.value` | integer | Current humidity value |
| `data.humidity.unit` | string | Unit of measurement (%) |
| `data.humidity.status` | string | Status: "Normal" or "Warning" |
| `system_overall` | string | Overall system status |
| `timestamp` | string | Measurement time (Y-m-d H:i:s) |

#### Status Logic

**Temperature:**
- Normal: Temperature <= -18.0°C
- Warning: Temperature > -18.0°C

**Humidity:**
- Normal: Humidity >= 85%
- Warning: Humidity < 85%

**System:**
- Normal: Both temperature and humidity are Normal
- Warning: One or both exceed thresholds

## Usage

### Testing the API

```bash
# View full response
curl -i http://localhost/sensorhv/api_sensor.php

# View JSON data only (requires jq)
curl -s http://localhost/sensorhv/api_sensor.php | jq .

# Check UTF-8 encoding
curl -s http://localhost/sensorhv/api_sensor.php | grep -o "Độ ẩm"
```

### JavaScript Integration

```javascript
async function getSensorData() {
  const response = await fetch('api_sensor.php');
  const data = await response.json();
  console.log(`Temperature: ${data.data.temperature.value}°C`);
  console.log(`Humidity: ${data.data.humidity.value}%`);
  return data;
}
```

### Python Integration

```python
import requests

response = requests.get('http://localhost/sensorhv/api_sensor.php')
data = response.json()
print(f"Temperature: {data['data']['temperature']['value']}°C")
print(f"Humidity: {data['data']['humidity']['value']}%")
```

## Technical Specifications

### Alert Thresholds

- **Safe Temperature:** <= -18.0°C (standard for frozen seafood storage)
- **Recommended Humidity:** >= 85% (prevents water loss and weight reduction)

### Encoding

- API uses full UTF-8 encoding
- Header `Content-Type: application/json; charset=UTF-8`
- PHP internal encoding: UTF-8
- JSON flag: `JSON_UNESCAPED_UNICODE` for accurate Vietnamese display

### CORS

API supports Cross-Origin Resource Sharing (CORS) with header:
```
Access-Control-Allow-Origin: *
```

## Future Extensions

### Database Connection

To store historical data, add MySQL connection with UTF-8 charset:

```php
// MySQLi
$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset('utf8mb4');

// PDO
$pdo = new PDO($dsn, $user, $pass);
$pdo->exec('SET NAMES utf8mb4');
```

### Real Sensor Integration

Replace `mt_rand()` function with data reading from hardware sensors via:
- Serial port (Arduino, ESP32)
- I2C/SPI (DHT22, BME280)
- MQTT broker (IoT platforms)

### Additional Features

- Send email/SMS alerts when thresholds exceeded
- Store history logs in database
- Temperature/humidity trend charts over time
- Export PDF/Excel reports
- API authentication with tokens

## Maintenance

### Update Alert Thresholds

Edit in `api_sensor.php`:

```php
$temp_threshold = -18.0;  // Temperature threshold
$humi_threshold = 85;     // Humidity threshold
```

### Change Update Frequency

Edit in `index.html`:

```javascript
setInterval(fetchData, 2000); // 2000ms = 2 seconds
```

## Troubleshooting

**Issue:** Vietnamese characters display incorrectly (mojibake)

**Solution:**
- Ensure PHP file is saved with UTF-8 encoding
- Check that web server has `mod_charset` module enabled
- Confirm browser is not overriding charset

**Issue:** API returns 500 error

**Solution:**
- Check PHP error log: `/Applications/MAMP/logs/php_error.log`
- Ensure PHP >= 7.0
- Verify file read permissions

## License

Open source project, free to use and modify for educational and commercial purposes.

## Author

IoT Cold Storage Monitoring System for Seafood - 2026

## Contact

Contributions and bug reports via GitHub Issues.
