<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Correio\Http\Controllers\CorreioController;
use App\Jobs\AtualizarRastreio;

class DadosCorreioTest extends TestCase
{
        public function testParametroErro()
    {   
        $correio = new CorreioController();
        $dados = $corrreio->dadosCorreio();
        $this->assertTrue($dados);

        
    }

     public function testParametroOk()
    {   
        $correio = new CorreioController();
        $dados = $corrreio->dadosCorreio("OH215715636BR");
        $this->assertTrue($dados);

        
    }

     public function testRetornoErro()
    {   
        $correio = new CorreioController();
        $dados = $corrreio->dadosCorreio("OH215715636BA");
        $this->assertNull($dados);

        
    }

    public function testRetornoOk()
    {   
        $correio = new CorreioController();
        $dados = $corrreio->dadosCorreio("OH215715636BR");
        $this->assertNull($dados);

        
    }








}
