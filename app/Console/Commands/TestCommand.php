<?php

namespace App\Console\Commands;

use App\Models\Note;
use App\Repositories\NoteRepository;
use Illuminate\Console\Command;
use function Laravel\Prompts\title;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Nhận data từ người dùng (người dùng muốn tạo note có password)
        // Anh ví dụ ban đầu chỉ cho người dùng tạo title
        $title = $this->ask('Nhập title của note:');
        $hasPassword = $this->ask('Bạn có muốn set password cho note không (yes/no)?');
        $hasPassword = strtolower($hasPassword); // phòng trường hợp nhập YES or Y

        if (in_array($hasPassword, ['yes', 'y'])) {
            $password = $this->ask('Nhập password:');
        } else {
            $password = null;
        }

        // Lưu db (chưa có data)
        // 1. Khởi tạo đối tượng
        $note = Note::make(
            title: $title,
            content: null,
            password: $password,
            userId: 1
        );

        // 2. Lưu db
        $note->save();
        $this->info('Note đã được tạo: ');
        $this->line(json_encode($note->toArray(), JSON_PRETTY_PRINT));

        // Người dùng truy cập vào để set content
        $editContent = $this->ask('Bạn có muốn chỉnh cotent cho note không (yes/no)?');
        $editContent = strtolower($editContent); // phòng trường hợp nhập YES or Y

        if (in_array($editContent, ['yes', 'y'])) {
            $noteId = $this->ask('Nhập ID của note bạn muốn edit:');
            $noteSetContent = Note::query()->find($noteId);

            if (!$noteSetContent) {
                $this->error('Note không tồn tại');
                return;
            }

            $content = $this->ask('Nhập content:');

            $noteSetContent->content = $content;
            $noteSetContent->save();

            $this->info('Content đã cập nhật!');
            $this->info('Note sau khi đã update:');
            $this->line(json_encode($noteSetContent->toArray(), JSON_PRETTY_PRINT));
        }
    }
}
