<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US26Test extends USTestBase
{
    protected $userToSimulate;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedDirecaoUser();
        $this->seedQuotaNaoPagaUser();        
        $this->userToSimulate = $this->direcaoUser;
    }

    public function testMostraBotaoQuotaPagaParaUmSocioSeDirecao()
    {
        $this->actingAs($this->userToSimulate)->get('/socios')
                ->assertStatus(200)
                ->assertSeeAll([
                    $this->normalUser->num_socio,
                    $this->normalUser->nome_informal,
                    $this->normalUser->email,                    
                ], "A lista com os sócios não apresenta um sócio normal")
                ->assertSeeInOrder_2(['<form', 'method="POST"', 'action', "socios/{$this->normalUser->id}/quota", '>',
                    '<input type="hidden" name="_method" value="patch">',
                    'name="quota_paga"',
                    '</form>'],
                    'A lista de sócios não tem nenhum botão ou hiperlink para declarar as quotas como pagas ou não pagas');
    }

    public function testMostraBotaoResetTodasQuotasSeDirecao()
    {
        $this->actingAs($this->userToSimulate)->get('/socios')
                ->assertStatus(200)
                ->assertSeeInOrder_2(['<form', 'method="POST"', 'action', "socios/reset_quotas", '>',
                    '<input type="hidden" name="_method" value="patch">',
                    '</form>'],
                    'A lista de sócios não tem nenhum botão ou hiperlink para fazer o Reset a todas as quotas');
    }

    public function testMostraBotaoQuotaPagaParaUmSocioSeSocioNormal()
    {
        $this->actingAs($this->normalUser)->get('/socios')
                ->assertStatus(200)
                ->assertDontSeeAll(["socios/{$this->normalUser->id}/quota"],
                    'A lista de sócios tem um botão ou hiperlink para declarar as quotas como pagas ou não pagas (só a direção é que deveria ver esse botão ou hiperligação)');
    }

    public function testMostraBotaoResetTodasQuotasSeSocioNormal()
    {
        $this->actingAs($this->normalUser)->get('/socios')
                ->assertStatus(200)
                ->assertDontSeeAll(["socios/reset_quotas"],
                    'A lista de sócios tem um botão ou hiperlink para fazer o Reset a todas as quotas (só a direção é que deveria ver esse botão ou hiperligação)');
    }


    public function testAlteraQuotaDeUmSocioComSucesso()
    {
        $oldQuotaPaga = DB::table('users')->where('id', $this->normalUser->id)->first()->quota_paga;
        try {
            $newQuota = $oldQuotaPaga == '1' ? '0' : '1';
            $this->actingAs($this->userToSimulate)->patch("socios/{$this->normalUser->id}/quota", ["quota_paga" => $newQuota])
                ->assertAllValid()
                ->assertSuccessfulOrRedirect();
            $newQuotaPagaFromDB = DB::table('users')->where('id', $this->normalUser->id)->first()->quota_paga;
            $this->assertTrue($newQuotaPagaFromDB == $newQuota, 'A operação para alterar o estado da quota paga de um sócio não atualizou corretamente a base de dados (1/2)');

            $oldQuotaPaga = $newQuotaPagaFromDB;
            $newQuota = $oldQuotaPaga == '1' ? '0' : '1';
            $this->actingAs($this->userToSimulate)->patch("socios/{$this->normalUser->id}/quota", ["quota_paga" => $newQuota])
                ->assertAllValid()
                ->assertSuccessfulOrRedirect();
            $newQuotaPagaFromDB = DB::table('users')->where('id', $this->normalUser->id)->first()->quota_paga;
            $this->assertTrue($newQuotaPagaFromDB == $newQuota, 'A operação para alterar o estado da quota paga de um sócio não atualizou corretamente a base de dados (2/2)');
        } finally {
            DB::table('users')->where('id', $this->normalUser->id)->update(['quota_paga' => $oldQuotaPaga]);
        }
    }

    public function testNaoAlteraQuotaDeUmSocioComSucessoSeSocioNormal()
    {
        $oldQuotaPaga = DB::table('users')->where('id', $this->normalUser->id)->first()->quota_paga;
        try {
            $newQuota = $oldQuotaPaga == '1' ? '0' : '1';
            $this->actingAs($this->normalUser)->patch("socios/{$this->normalUser->id}/quota", ["quota_paga" => $newQuota]);
            $newQuotaPagaFromDB = DB::table('users')->where('id', $this->normalUser->id)->first()->quota_paga;
            $this->assertTrue($newQuotaPagaFromDB == $oldQuotaPaga, 'Sócio normal consegue executar a operação para alterar o estado da quota paga de um sócio e a base de dados for atualizada!');

        } finally {
            DB::table('users')->where('id', $this->normalUser->id)->update(['quota_paga' => $oldQuotaPaga]);
        }
    }

    public function testResetTodasQuotasComSucesso()
    {
        $oldQuotasNaoPagas = DB::table('users')->whereNull('deleted_at')->where('quota_paga', 0)->get()->pluck('id');
        $totalOldQuotasNaoPagas = count($oldQuotasNaoPagas);
        $oldQuotasPagas = DB::table('users')->whereNull('deleted_at')->where('quota_paga', 1)->get()->pluck('id');
        $totalOldQuotasPagas = count($oldQuotasPagas);
        try {
            $this->actingAs($this->userToSimulate)->patch("socios/reset_quotas")
                ->assertAllValid()
                ->assertSuccessfulOrRedirect();
            $totalNewQuotasNaoPagas = DB::table('users')->whereNull('deleted_at')->where('quota_paga', 0)->count();
            $totalNewQuotasPagas = DB::table('users')->whereNull('deleted_at')->where('quota_paga', 1)->count();

            $this->assertTrue($totalNewQuotasPagas == 0, 'A operação para fazer o reset de todas as quotas não atualizou corretamente a base de dados. Ainda existem quotas consideradas como pagas');
            $this->assertTrue($totalNewQuotasNaoPagas == ($totalOldQuotasNaoPagas + $totalOldQuotasPagas), 'A operação para fazer o reset de todas as quotas não atualizou corretamente a base de dados. O total de quotas consideradas como não pagas não corresponde ao total de sócios');
        } finally {
            DB::table('users')->whereNull('deleted_at')->whereIn('id', $oldQuotasNaoPagas)->update(['quota_paga' => 0]);
            DB::table('users')->whereNull('deleted_at')->whereIn('id', $oldQuotasPagas)->update(['quota_paga' => 1]);
        }
    }

    public function testNaoFazResetTodasQuotasSeSocioNormal()
    {
        $oldQuotasNaoPagas = DB::table('users')->whereNull('deleted_at')->where('quota_paga', 0)->get()->pluck('id');
        $totalOldQuotasNaoPagas = count($oldQuotasNaoPagas);
        $oldQuotasPagas = DB::table('users')->whereNull('deleted_at')->where('quota_paga', 1)->get()->pluck('id');
        $totalOldQuotasPagas = count($oldQuotasPagas);
        try {
            $this->actingAs($this->normalUser)->patch("socios/reset_quotas");
            $totalNewQuotasNaoPagas = DB::table('users')->whereNull('deleted_at')->where('quota_paga', 0)->count();
            $totalNewQuotasPagas = DB::table('users')->whereNull('deleted_at')->where('quota_paga', 1)->count();

            $this->assertTrue($totalOldQuotasNaoPagas == $totalNewQuotasNaoPagas,  'Sócio normal consegue executar a operação para fazer o reset de todas as quotas de sócio e as quotas na base de dados foram alteradas!');
            
            $this->assertTrue($totalOldQuotasPagas == $totalNewQuotasPagas,  'Sócio normal consegue executar a operação para fazer o reset de todas as quotas de sócio e as quotas na base de dados foram alteradas!');            
        } finally {
            DB::table('users')->whereNull('deleted_at')->whereIn('id', $oldQuotasNaoPagas)->update(['quota_paga' => 0]);
            DB::table('users')->whereNull('deleted_at')->whereIn('id', $oldQuotasPagas)->update(['quota_paga' => 1]);
        }
    }
}


