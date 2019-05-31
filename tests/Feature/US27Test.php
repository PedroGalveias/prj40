<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US27Test extends USTestBase
{
    protected $userToSimulate;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedDirecaoUser();
        $this->seedDesativadoUser();        
        $this->userToSimulate = $this->direcaoUser;
    }

    public function testMostraBotaoAtivarParaUmSocioSeDirecao()
    {
        $this->actingAs($this->userToSimulate)->get('/socios')
                ->assertStatus(200)
                ->assertSeeAll([
                    $this->normalUser->num_socio,
                    $this->normalUser->nome_informal,
                    $this->normalUser->email,                    
                ], "A lista com os sócios não apresenta um sócio normal")
                ->assertSeeInOrder_2(['<form', 'method="POST"', 'action', "socios/{$this->normalUser->id}/ativo", '>',
                    '<input type="hidden" name="_method" value="patch">',
                    'name="ativo"',
                    '</form>'],
                    'A lista de sócios não tem botões ou hiperlinks para ativar/desativar um sócio');
    }

    public function testMostraBotaoDesativarSemQuotasSeDirecao()
    {
        $this->actingAs($this->userToSimulate)->get('/socios')
                ->assertStatus(200)
                ->assertSeeInOrder_2(['<form', 'method="POST"', 'action', "socios/desativar_sem_quotas", '>',
                    '<input type="hidden" name="_method" value="patch">',
                    '</form>'],
                    'A lista de sócios não tem nenhum botão ou hiperlink para desativar todos os sócios sem quotas');
    }

    public function testMostraBotaoQuotaPagaParaUmSocioSeSocioNormal()
    {
        $this->actingAs($this->normalUser)->get('/socios')
                ->assertStatus(200)
                ->assertDontSeeAll(["socios/{$this->normalUser->id}/ativo"],
                    'A lista de sócios tem botões ou hiperlinks para ativar/desativar um sócio(só a direção é que deveria ver esse botão ou hiperligação)');
    }

    public function testMostraBotaoDesativarSemQuotasSeSocioNormal()
    {
        $this->actingAs($this->normalUser)->get('/socios')
                ->assertStatus(200)
                ->assertDontSeeAll(["socios/desativar_sem_quotas"],
                    'A lista de sócios tem um botão ou hiperlink para desativar todos os sócios sem quotas pagas (só a direção é que deveria ver esse botão ou hiperligação)');
    }


    public function testAlteraAtivoDeUmSocioComSucesso()
    {
        $oldAtivo = DB::table('users')->where('id', $this->normalUser->id)->first()->ativo;
        try {
            $newAtivo = $oldAtivo == '1' ? '0' : '1';
            $this->actingAs($this->userToSimulate)->patch("socios/{$this->normalUser->id}/ativo", ["ativo" => $newAtivo])
                ->assertAllValid()
                ->assertSuccessfulOrRedirect();
            $newAtivoFromDB = DB::table('users')->where('id', $this->normalUser->id)->first()->ativo;
            $this->assertTrue($newAtivoFromDB == $newAtivo, 'A operação para alterar o estado ativo/desativado de um sócio não atualizou corretamente a base de dados (1/2)');

            $oldAtivo = $newAtivoFromDB;
            $newAtivo = $oldAtivo == '1' ? '0' : '1';
            $this->actingAs($this->userToSimulate)->patch("socios/{$this->normalUser->id}/ativo", ["ativo" => $newAtivo])
                ->assertAllValid()
                ->assertSuccessfulOrRedirect();
            $newAtivoFromDB = DB::table('users')->where('id', $this->normalUser->id)->first()->ativo;
            $this->assertTrue($newAtivoFromDB == $newAtivo, 'A operação para alterar o estado ativo/desativado de um sócio não atualizou corretamente a base de dados (2/2)');
        } finally {
            DB::table('users')->where('id', $this->normalUser->id)->update(['ativo' => $oldAtivo]);
        }
    }

    public function testNaoAlteraAtivoDeUmSocioComSucessoSeSocioNormal()
    {
        $oldAtivo = DB::table('users')->where('id', $this->normalUser->id)->first()->ativo;
        try {
            $newAtivo = $oldAtivo == '1' ? '0' : '1';
            $this->actingAs($this->normalUser)->patch("socios/{$this->normalUser->id}/ativo", ["ativo" => $newAtivo]);
            $newAtivoFromDB = DB::table('users')->where('id', $this->normalUser->id)->first()->ativo;
            $this->assertTrue($newAtivoFromDB == $oldAtivo, 'Sócio normal consegue executar a operação para ativar/desativar um sócio e a base de dados for atualizada!');

        } finally {
            DB::table('users')->where('id', $this->normalUser->id)->update(['ativo' => $oldAtivo]);
        }
    }

    public function testDesativarTodosSemQuotasComSucesso()
    {
        $oldDesativos = DB::table('users')->whereNull('deleted_at')->where('ativo', 0)->get()->pluck('id');
        $oldAtivos = DB::table('users')->whereNull('deleted_at')->where('ativo', 1)->get()->pluck('id');
        $oldQuotasPagas = DB::table('users')->whereNull('deleted_at')->where('quota_paga', 1)->get()->pluck('id');
        $oldQuotasNaoPagas = DB::table('users')->whereNull('deleted_at')->where('quota_paga', 0)->get()->pluck('id');

        try {
            $allSocios = DB::table('users')->whereNull('deleted_at')->get()->pluck('id');

            if (count($allSocios) >= 4) {
                DB::table('users')->whereNull('deleted_at')->where('id', $allSocios[0])->update(['ativo'=>1, 'quota_paga'=>0]);
                DB::table('users')->whereNull('deleted_at')->where('id', $allSocios[1])->update(['ativo'=>0, 'quota_paga'=>1]);
                DB::table('users')->whereNull('deleted_at')->where('id', $allSocios[2])->update(['ativo'=>1, 'quota_paga'=>1]);
                DB::table('users')->whereNull('deleted_at')->where('id', $allSocios[3])->update(['ativo'=>1, 'quota_paga'=>0]);
                $this->actingAs($this->userToSimulate)->patch("socios/desativar_sem_quotas")
                    ->assertAllValid()
                    ->assertSuccessfulOrRedirect();

                $dbUser = DB::table('users')->whereNull('deleted_at')->where('id', $allSocios[0])->first();
                $this->assertTrue(($dbUser->ativo == 0) && ($dbUser->quota_paga == 0), 'A operação para desativar todos os sócios com quotas por pagar não atualizou corretamente a base de dados (1/4)');

                $dbUser = DB::table('users')->whereNull('deleted_at')->where('id', $allSocios[1])->first();
                $this->assertTrue(($dbUser->ativo == 0) && ($dbUser->quota_paga == 1), 'A operação para desativar todos os sócios com quotas por pagar não atualizou corretamente a base de dados (2/4)');

                $dbUser = DB::table('users')->whereNull('deleted_at')->where('id', $allSocios[2])->first();
                $this->assertTrue(($dbUser->ativo == 1) && ($dbUser->quota_paga == 1), 'A operação para desativar todos os sócios com quotas por pagar não atualizou corretamente a base de dados (3/4)');

                $dbUser = DB::table('users')->whereNull('deleted_at')->where('id', $allSocios[3])->first();
                $this->assertTrue(($dbUser->ativo == 0) && ($dbUser->quota_paga == 0), 'A operação para desativar todos os sócios com quotas por pagar não atualizou corretamente a base de dados (4/4)');
            } else {
                $this->assertTrue(false, 'Não foi possível testar a operação para desativar todos os sócios com quotas por pagar porque não há sócios sufucientes (são necessários 4 sócios)');
            }

        } finally {
            DB::table('users')->whereNull('deleted_at')->whereIn('id', $oldDesativos)->update(['ativo' => 0]);
            DB::table('users')->whereNull('deleted_at')->whereIn('id', $oldAtivos)->update(['ativo' => 1]);
            DB::table('users')->whereNull('deleted_at')->whereIn('id', $oldQuotasNaoPagas)->update(['quota_paga' => 0]);
            DB::table('users')->whereNull('deleted_at')->whereIn('id', $oldQuotasPagas)->update(['quota_paga' => 1]);
        }
    }

    public function testNaoDesativaTodosSemQuotasSeSocioNormal()
    {
        $oldDesativos = DB::table('users')->whereNull('deleted_at')->where('ativo', 0)->get()->pluck('id');
        $oldAtivos = DB::table('users')->whereNull('deleted_at')->where('ativo', 1)->get()->pluck('id');
        $oldQuotasPagas = DB::table('users')->whereNull('deleted_at')->where('quota_paga', 1)->get()->pluck('id');
        $oldQuotasNaoPagas = DB::table('users')->whereNull('deleted_at')->where('quota_paga', 0)->get()->pluck('id');
        try {
            $idToTest = -1;
            if (count($oldAtivos) < 1) {
                DB::table('users')->whereNull('deleted_at')->where('id', $oldDesativos[0])->update(['ativo'=>1]);
                $idToTest = $oldDesativos[0];
            } else {
                $idToTest = $oldAtivos[0];
            }
            DB::table('users')->whereNull('deleted_at')->where('id', $idToTest)->update(['ativo'=>1, 'quota_paga'=>0]);
            $this->actingAs($this->normalUser)->patch("socios/desativar_sem_quotas");

            $dbUser = DB::table('users')->whereNull('deleted_at')->where('id', $idToTest)->first();
            $this->assertTrue(($dbUser->ativo == 1) && ($dbUser->quota_paga == 0), 'Sócio normal consegue executar a operação para desativar todos os sócios com quotas por pagar e a base de dados foi alterada!');

        } finally {
            DB::table('users')->whereNull('deleted_at')->whereIn('id', $oldDesativos)->update(['ativo' => 0]);
            DB::table('users')->whereNull('deleted_at')->whereIn('id', $oldAtivos)->update(['ativo' => 1]);
            DB::table('users')->whereNull('deleted_at')->whereIn('id', $oldQuotasNaoPagas)->update(['quota_paga' => 0]);
            DB::table('users')->whereNull('deleted_at')->whereIn('id', $oldQuotasPagas)->update(['quota_paga' => 1]);
        }
    }
}


