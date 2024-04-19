<?php

namespace CommunityCRM\Search;

use CommunityCRM\Authentication\AuthenticationManager;
use CommunityCRM\dto\SystemConfig;
use CommunityCRM\dto\SystemURLs;
use CommunityCRM\model\CommunityCRM\DepositQuery;
use CommunityCRM\Utils\LoggerUtils;
use Propel\Runtime\ActiveQuery\Criteria;

class FinanceDepositSearchResultProvider extends BaseSearchResultProvider
{
    public function __construct()
    {
        $this->pluralNoun = 'Deposits';
        parent::__construct();
    }

    public function getSearchResults(string $SearchQuery)
    {
        if (AuthenticationManager::getCurrentUser()->isFinanceEnabled()) {
            if (SystemConfig::getBooleanValue('bSearchIncludeDeposits')) {
                $this->addSearchResults($this->getDepositSearchResults($SearchQuery));
            }
        }

        return $this->formatSearchGroup();
    }

    /**
     * @return SearchResult[]
     */
    private function getDepositSearchResults(string $SearchQuery): array
    {
        $searchResults = [];
        $id = 0;

        try {
            $Deposits = DepositQuery::create()->filterByComment("%$SearchQuery%", Criteria::LIKE)
                ->_or()
                ->filterById($SearchQuery)
                ->withColumn('CONCAT("#",Deposit.Id," ",Deposit.Comment)', 'displayName')
                ->withColumn('CONCAT("' . SystemURLs::getRootPath() . '/DepositSlipEditor.php?DepositSlipID=",Deposit.Id)', 'uri')
                ->limit(SystemConfig::getValue('bSearchIncludeDepositsMax'))->find();

            if (!empty($Deposits)) {
                $id++;
                foreach ($Deposits->toArray() as $Deposit) {
                    $searchResults[] = new SearchResult('finance-deposit-' . $id, $Deposit['displayName'], $Deposit['uri']);
                }
            }
        } catch (\Exception $e) {
            LoggerUtils::getAppLogger()->warning($e->getMessage());
        }

        return $searchResults;
    }
}
