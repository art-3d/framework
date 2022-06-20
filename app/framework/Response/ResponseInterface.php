<?php

namespace Framework\Response;

interface ResponseInterface
{
	public function send(): void;
	public function setHeader(string $header): void;
	public function getContent();
	public function getCode();
}
