<?php
/**
 *
 * @package phpBB Extension - Stop spamer register
 * @copyright (c) 2017 Sheer
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */
namespace sheer\stopregister\tests\functional;

/**
 * @group functional
 */
class stop_spammer_register_test extends \phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return ['sheer/stopregister'];
	}

	public function test_acp_module()
	{
		$this->login();
		$this->admin_login();

		$this->add_lang_ext('sheer/stopregister', ['stopregister', 'info_acp_stopregister']);
		$this->add_lang('mcp');

		$crawler = self::request('GET', "adm/index.php?sid={$this->sid}&i=acp_board&mode=registration");
		$this->assertContainsLang('ALLOW_STOPFORUMSPAM', $crawler->filter('label[for="enable_stopforumspam"]')->text());

		$crawler = self::request('GET', "adm/index.php?sid={$this->sid}&i=-sheer-stopregister-acp-main_module&mode=register");
		$this->assertContainsLang('ACP_REGISTER_LOGS', $crawler->filter('div.main h1')->text());
		$this->assertContainsLang('NO_ENTRIES', $crawler->filter('div.errorbox > p')->text());
	}
}
