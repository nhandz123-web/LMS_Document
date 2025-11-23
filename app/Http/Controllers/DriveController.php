<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DriveController extends Controller
{
    public function form()
    {
        // Link tới thư mục Google Drive để hiển thị nút "Mở Drive"
        $folderUrl = 'https://drive.google.com/drive/folders/' . env('GOOGLE_DRIVE_FOLDER_ID');
        return view('drive.upload', compact('folderUrl'));
    }


    public function upload(Request $request)
    {
        // cho phép file tới 50MB, thêm định dạng nếu cần
        $request->validate([
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,jpg,jpeg,png', 'max:51200'],
        ]);

        $file = $request->file('file');

        // tên sạch + giữ phần mở rộng
        $base = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext  = $file->getClientOriginalExtension();
        $driveName = now()->format('Ymd_His') . '__' . Str::slug($base, '_') . '.' . $ext;

        // upload bằng stream (ổn định)
        $stream = fopen($file->getRealPath(), 'r');
        $stored = Storage::disk('google')->writeStream($driveName, $stream);
        if (is_resource($stream)) fclose($stream);

        // kiểm tra tồn tại thật (một số adapter trả null nhưng file vẫn lên)
        $exists = Storage::disk('google')->exists($driveName);
        if (!$exists && empty($stored)) {
            return back()->withErrors(['file' => 'Upload thất bại lên Google Drive.'])->withInput();
        }

        // nếu adapter trả về fileId thì tạo link xem
        $fileId  = is_string($stored) ? $stored : null;
        $viewUrl = $fileId ? "https://drive.google.com/file/d/{$fileId}/view" : null;

        return back()->with([
            'ok'      => true,
            'name'    => $driveName,
            'viewUrl' => $viewUrl,
        ]);
    }
}
