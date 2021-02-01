<?php

namespace SegPartners\QuiverWrapper\Notebooks;

use Carbon\Carbon;
use SegPartners\QuiverWrapper\Auth\BearerTokenAuthorization;
use SegPartners\QuiverWrapper\Client;
use SegPartners\QuiverWrapper\Interfaces\AuthorizationInterface;
use SegPartners\QuiverWrapper\Interfaces\Method;

class NotebooksStore extends Method
{

    const QUIVER_DEFAULT_DATE_FORMAT = 'Y-m-d';

    private $client;
    private $subject;
    private $description;
    private $document;
    private $change;

    private $assignment;
    private $responsible;
    private $limit_date;

    public function __construct(int $client, string $subject, string $description, int $document, int $change)
    {
        $this->client = $client;
        $this->subject = $subject;
        $this->description = $description;
        $this->document = $document;
        $this->change = $change;
    }

    public function makeAssigment($responsible, Carbon $limit_date): self
    {
        $this->assignment = true;
        $this->responsible = $responsible;
        $this->limit_date = $limit_date->format(self::QUIVER_DEFAULT_DATE_FORMAT);
        return $this;
    }

    public function getFormParams(): array
    {
        $notebookParams = [
            'client' => $this->client,
            'subject' => $this->subject,
            'description' => $this->description,
            'document' => $this->document,
            'change' => $this->change,
        ];

        $assigmentParams = [
            'assignment' => $this->assignment,
            'responsible' => $this->responsible,
            'limit_date' => $this->limit_date,
        ];

        return $this->assignment
            ? array_merge($notebookParams, $assigmentParams)
            : $notebookParams;

    }

    public function authorizeUsing(): AuthorizationInterface
    {
        return new BearerTokenAuthorization;
    }

    public function getMethodUri(): string
    {
        return 'api/notebooks';
    }

    public function getMethod(): string
    {
        return Client::HTTP_METHOD_POST;
    }
}