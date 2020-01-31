<?php

namespace SegPartners\QuiverWrapper\Attachments;

use SegPartners\QuiverWrapper\Auth\BearerTokenAuthorization;
use SegPartners\QuiverWrapper\Interfaces\AuthorizationInterface;
use SegPartners\QuiverWrapper\Interfaces\Method;

class AttachmentsStore extends Method
{
    private $client;
    private $description;
    private $document;
    private $change;
    private $image_type;
    private $file_type;
    private $file;
    private $file_name;

    public function __construct($description, $client, $document, $change, $image_type, $file_type, string $file, string $file_name)
    {
        $this->description = $description;
        $this->client = $client;
        $this->document = $document;
        $this->change = $change;
        $this->image_type = $image_type;
        $this->file_type = $file_type;
        $this->file = $file;
        $this->file_name = $file_name;
    }

    public function authorizeUsing(): AuthorizationInterface
    {
        return new BearerTokenAuthorization();
    }

    public function getMultiPartParams(): array
    {
        return [
            $this->generateFileFormField('file', $this->file, $this->file_name),
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
