<?php
/** This file can't be modified */
namespace SP\Infrastructure;
interface Kernel
{
    public static function createWithDataSet(array $dataset): static;
    public function run(Request $request): Response;
}

interface Request
{
    public function getUri(): string;

    public function getMethod(): string;

    public function getBody(): string;
}

interface Response
{
    public function getStatusCode(): int;

    public function getBody(): string;
}
