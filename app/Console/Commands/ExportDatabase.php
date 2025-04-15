<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class BackupDatabase extends Command
{
    protected $signature = 'db:backup';
    protected $description = 'Export the database to a specific folder';

    public function handle()
    {
        // بيانات الاتصال
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $port = env('DB_PORT', 3306);

        // المسار اللي هيتم الحفظ فيه (تأكد من تغييره للمسار اللي انت عايزه)
        $backupPath = storage_path('app/backups');

        // تأكد أن الفولدر موجود
        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        // اسم الملف بالتاريخ والوقت
        $fileName = 'backup_' . Carbon::now()->format('Y_m_d_H_i_s') . '.sql';

        // أمر التصدير
        $command = "mysqldump -h {$host} -P {$port} -u {$username} -p\"{$password}\" {$database} > \"{$backupPath}\\{$fileName}\"";

        // تنفيذ الأمر
        $result = null;
        $output = null;
        exec($command, $output, $result);

        if ($result === 0) {
            $this->info("✅ تم إنشاء نسخة احتياطية في: {$backupPath}\\{$fileName}");
        } else {
            $this->error('❌ فشل في إنشاء النسخة الاحتياطية.');
        }
    }
}
