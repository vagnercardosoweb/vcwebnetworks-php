<?php

/**
 * VCWeb Networks <https://www.vcwebnetworks.com.br/>.
 *
 * @author    Vagner Cardoso <vagnercardosoweb@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @copyright 31/05/2019 Vagner Cardoso
 */

namespace Core\Contracts {
    use Core\App;
    use Phinx\Migration\AbstractMigration;

    /**
     * Class Migration.
     *
     * @author Vagner Cardoso <vagnercardosoweb@gmail.com>
     */
    abstract class Migration extends AbstractMigration
    {
        /**
         * @var string
         */
        protected $table = '';

        /**
         * @var string
         */
        protected $engine = 'InnoDB';

        /**
         * @var string
         */
        protected $collation = 'utf8_general_ci';

        /**
         * @var string|bool
         */
        protected $primaryKey = false;

        /**
         * @var array
         */
        protected $primaryKeys = [];

        /**
         * @param string $name
         *
         * @return mixed
         */
        public function __get($name)
        {
            return App::getInstance()
                ->resolve($name)
            ;
        }

        /**
         * @throws \Exception
         */
        public function down()
        {
            $this->table($this->table)->drop()->save();
        }

        /**
         * @param string|null $table
         * @param array       $options
         *
         * @return \Phinx\Db\Table
         *
         * @throws \Exception
         */
        public function table($table = null, $options = [])
        {
            // Variávies
            $table = $table ?? $this->table;

            // Verifica a tabela
            if (empty($table)) {
                throw new \Exception(
                    sprintf('Table not defined in %s.', get_class($this)),
                    E_ERROR
                );
            }

            // Retorna o método pai
            return parent::table($table, array_merge([
                'id' => $this->primaryKey,
                'engine' => $this->engine,
                'collation' => $this->collation,
                'primary_key' => $this->primaryKeys,
            ], $options));
        }
    }
}
