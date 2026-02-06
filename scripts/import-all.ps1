param(
    [string]$Database = "z1helpdesk",
    [string]$User = "root",
    [string]$Host = "127.0.0.1",
    [int]$Port = 3306
)

$files = @(
    "sql/001_init.sql",
    "sql/010_auth.sql",
    "sql/020_customers.sql",
    "sql/021_organizations.sql",
    "sql/030_tickets.sql",
    "sql/040_faq.sql",
    "sql/050_settings.sql",
    "sql/060_audit.sql",
    "sql/900_seed.sql"
)

foreach ($file in $files) {
    Write-Host "Importing $file..."
    & mysql -h $Host -P $Port -u $User -p $Database < $file
    if ($LASTEXITCODE -ne 0) {
        Write-Error "Failed on $file"
        exit 1
    }
}

Write-Host "All SQL files imported successfully."
