<?php

namespace KmaExtendedEmotion\Services;

use Doctrine\DBAL\Connection;

class EmotionDataService
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function selectEmotionData($attribute)
    {
        $attribute = explode("|", $attribute);
        unset($attribute[count($attribute)-1]);
        unset($attribute[0]);
        $attribute = array_values($attribute);//remap array indices
        $placeholders = str_repeat ('?, ',  count ($attribute) - 1) . '?';

        $query = $this->connection->createQueryBuilder();

        $query->select('id,device')
            ->from('s_emotion')
            ->where('id = $placeholders')
            ->andWhere('active = 1')
            ->addOrderBy('position', 'ASC');


        return $query->execute()->fetchAll(\PDO::FETCH_ASSOC);

    }

}