<?php

namespace Tests\Unit;

use App\Services\PddiktiService;
use Tests\TestCase;

class PddiktiServiceTest extends TestCase
{
    public function test_validates_untirta_nim_ft_cilegon(): void
    {
        $service = new PddiktiService();
        $result = $service->validateNim('3337220001');

        $this->assertTrue($result['valid']);
        $this->assertEquals('untirta_verified', $result['source']);
        $this->assertEquals('Universitas Sultan Ageng Tirtayasa', $result['university']);
        $this->assertStringContainsString('Fakultas Teknik', $result['message']);
        $this->assertStringContainsString('Angkatan 2022', $result['message']);
    }

    public function test_validates_untirta_nim_fisip_sindangsari(): void
    {
        $service = new PddiktiService();
        $result = $service->validateNim('6661220002');

        $this->assertTrue($result['valid']);
        $this->assertEquals('untirta_verified', $result['source']);
        $this->assertStringContainsString('Fakultas Ilmu Sosial', $result['message']);
    }

    public function test_rejects_invalid_length_nim(): void
    {
        $service = new PddiktiService();
        $result = $service->validateNim('333722');

        $this->assertFalse($result['valid']);
        $this->assertEquals('format_error', $result['source']);
    }

    public function test_rejects_non_untirta_prefix(): void
    {
        $service = new PddiktiService();
        $result = $service->validateNim('9991234567');

        $this->assertFalse($result['valid']);
        $this->assertEquals('untirta_invalid', $result['source']);
    }
}
