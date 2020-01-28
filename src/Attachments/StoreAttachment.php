<?php

namespace SegPartners\QuiverWrapper\Attachments;

use Illuminate\Http\UploadedFile;
use SegPartners\QuiverWrapper\Auth\BearerTokenAuthorization;
use SegPartners\QuiverWrapper\Interfaces\AuthorizationInterface;
use SegPartners\QuiverWrapper\Interfaces\Method;

class StoreAttachment extends Method
{
    private $client;
    private $description;
    private $document;
    private $change;
    private $image_type;
    private $file_type;
    private $file;

    public function __construct($description, $client, $document, $change, $image_type, $file_type, UploadedFile $file = null)
    {
        $this->description = $description;
        $this->client = $client;
        $this->document = $document;
        $this->change = $change;
        $this->image_type = $image_type;
        $this->file_type = $file_type;
        $this->file = $file;
    }

    public function authorizeUsing(): AuthorizationInterface
    {
        return new BearerTokenAuthorization();
    }

    public function getMultiPartParams(): array
    {
        return [
            'name' => 'file',
            'contents' => file_get_contents($this->file),
            'filename' => $this->file->getClientOriginalName(),
        ];
    }

    public function getMethod(): string
    {
        return 'post';
    }

    public function getFormParams(): array
    {
        return [
            'description' => $this->description,
            'client' => $this->client,
            'document' => $this->document,
            'change' => $this->change,
            'image_type' => $this->image_type,
            'file_type' => $this->file_type,
        ];
    }

    public function getMethodUri(): string
    {
        return 'api/attachments';
    }
}
