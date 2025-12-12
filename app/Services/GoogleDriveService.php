<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;

class GoogleDriveService
{
//   Kết nối tài khoản Google của bạn

// Tạo access_token từ refresh_token

// Lưu token hợp lệ vào client để gửi request lên Google Drive API

// Mọi request đến Google Drive API sẽ fail

    private function client(): Client
    {
        $client = new Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->addScope(Drive::DRIVE);                 // hoặc Drive::DRIVE_FILE
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        $refreshToken = trim((string) env('GOOGLE_OAUTH_REFRESH_TOKEN'));

        // Đổi refresh_token -> access_token TRƯỚC
        $token = $client->fetchAccessTokenWithRefreshToken($refreshToken);
        if (isset($token['error'])) {
            throw new \RuntimeException('Refresh token invalid: ' . $token['error_description'] ?? $token['error']);
        }

        // Gắn token hợp lệ cho client
        $client->setAccessToken($token);
        return $client;
    }

    //Tạo class Google Drive API chính thức
    //upload,down....
    private function service(): Drive
    {
        return new Drive($this->client());
    }

    public function upload($file, $name = null)
    {
        $service = $this->service();
        $meta = new DriveFile([
            'name'    => $name ?: $file->getClientOriginalName(),
            'parents' => [env('GOOGLE_DRIVE_FOLDER_ID')],
        ]);

        return $service->files->create($meta, [
            'data'       => file_get_contents($file->getRealPath()),
            'mimeType'   => $file->getMimeType(),
            'uploadType' => 'multipart',
            'fields'     => 'id,name,webViewLink,webContentLink',
        ]);
    }

    public function rename($fileId, $newName)
    {
        try {
            $service = $this->service();
            // Tạo metadata mới chứa tên mới
            $fileMetadata = new DriveFile([
                'name' => $newName
            ]);

            // Gọi API update
            return $service->files->update($fileId, $fileMetadata, [
                'fields' => 'id, name'
            ]);
        } catch (\Exception $e) {
            // Log lỗi nếu cần
            return false;
        }
    }

    // Xoá file
    public function delete($fileId)
    {
        $this->service()->files->delete($fileId);
    }

    // Tải file
    public function download($fileId)
    {
        $response = $this->service()->files->get($fileId, ['alt' => 'media']);
        return $response->getBody()->getContents();
    }
    public function listFiles()
    {
        $folderId = env('GOOGLE_DRIVE_FOLDER_ID');

        // Query: Lấy file nằm trong folder cha, và không phải là thùng rác (trashed = false)
        $query = "'{$folderId}' in parents and trashed = false";

        $files = $this->service()->files->listFiles([
            'q' => $query,
            'fields' => 'files(id, name, mimeType, webViewLink, createdTime)' // Lấy các trường cần thiết
        ]);

        return $files->getFiles();
    }
}
