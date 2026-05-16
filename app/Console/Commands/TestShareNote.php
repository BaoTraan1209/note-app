<?php

namespace App\Console\Commands;

use App\Helpers\AuthHelper;
use App\Mail\ShareNoteMail;
use App\Repositories\NoteRepository;
use App\Services\NoteService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestShareNote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:share-note {noteId : Note id} {email : Receiver email}';

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
        $noteId = (int) $this->argument('noteId');
        $email = $this->argument('email');

        // 1. Tìm note để có biến Note $note

        $note = app(NoteRepository::class)->findById($noteId);



        // 2. check Note xem có không
        if (!$note) {
            $this->error('Note not found');
            return self::FAILURE;
        }
        /*
         if(!note
            Không thì
            $this->error('Note not found.');
            return self::FAILURE;
        */

        // 3. dựng $noteUrl và $senderName
        $noteUrl= route ('notes.show', $note->getKey());
//        $senderName = AuthHelper::getUser()->name;
        $senderName= 'thaian';
        // gợi ý $noteUrl có thể gọi route('ten_route_show')
        // senderName có thể gọi từ user đăng nhập hiện tại trỏ tới name

        // 4. Khởi tạo mail
        $mail= new ShareNoteMail( $note,$senderName,$noteUrl);
        // 5. Send email bằng cách gọi Mail::to(email_cần_gửi_tới)->send(mail_đã_khởi_tạo)
        Mail::to($email)->send($mail);

        $this->info('Share note mail sent successfully.');

        return self::SUCCESS;
    }
}
