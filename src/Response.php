<?php
namespace Robert\Materialverwaltung;

# response structure: { data = {}, status = ""}

class Response
{
    private int $status;
    private array $data;
    private string $errorMessage;

    public function __construct(array $data, int $status = 200, string $errorMessage = "")
    {
        $this->data = $data;
        $this->status = $status;
        $this->errorMessage = $errorMessage;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }
}
