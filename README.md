# Log Analyzer

Log Analyzer is a Laravel-based application that helps developers and system administrators to monitor and manage application errors. It provides detailed reports, alerts, and the ability to track issues over time.

## Features

- **Error Reports**: View comprehensive reports of all logged errors in your application.
- **Issue Tracking**: Display a list of reported issues along with their first occurrence and last seen dates.
- **Issue Details**: Drill down into each issue to view detailed information, including a list of all occurrences.
- **Alerting System**:
  - Receive alerts when new issues are reported.
  - Get notified when an issue reoccurs after being resolved.
- **Silencing Alerts**: Option to silence alerts for specific issues, preventing further notifications.

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/wesamls/log-analyzer.git
   ```

2. Navigate to the project directory:
   ```bash
   cd log-analyzer
   ```

3. Install dependencies:
   ```bash
   composer install
   ```

4. Set up the environment file:
   ```bash
   cp .env.example .env
   ```

5. Generate the application key:
   ```bash
   php artisan key:generate
   ```

6. Configure your database settings in the `.env` file.

7. Run migrations to set up the database:
   ```bash
   php artisan migrate
   ```

8. Start the application:
   ```bash
   php artisan serve
   ```

## Usage

- Access the dashboard at `http://localhost:8000` to view error reports and manage issues.
- To enable Google Chat alerts, check Alerts section below.
- Silence alerts for specific issues directly from the issue detail page, preventing further notifications.

## Alerts

The application currently supports Google Chat alerts. Alerts are triggered in the following cases:
- A **new issue** is reported for the first time.
- A **reoccurred issue** is logged after being previously resolved.

To enable Google Chat alerts, add your Google Chat webhook URL in the `.env` file:

```env
GOOGLE_CHAT_WEBHOOK_URL=your-webhook-url-here
```

You can silence alerts for specific issues through the UI to prevent further notifications.

## Contributing

We welcome contributions! Please submit a pull request with detailed descriptions of the changes you are proposing.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
