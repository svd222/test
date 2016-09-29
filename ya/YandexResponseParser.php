<?php
/**
 * Парсинг данных от Ya.Деньги
 * User: svd
 * @date: 29.09.16
 * @time: 10:55
 */
namespace svd\ya;

/**
 * Class YandexResponseParser Парсит данные от Ya.Деньги
 *
 * @package svd
 */
class YandexResponseParser {

    /**
     * @var array $config Настройки парсинга
     * [
     *      'asArray' => bool Возвращать ли результат как массив
     *      'decimals' => int Количество дробных в формате ответа для float значений
     *      'dec_point' => string Разделитель дробных в формате ответа для float значений
     *      'thousands_sep' => string Разделитель тысячных в формате ответа для float значений
     * ]
     */
    protected $config;

    const SUM_EXP ='/\d+[,\.]\d*[р]/mis';

    const ACCOUNT_NUMBER_EXP = '/\d{14,16}/mis';

    const PASSWORD_EXP = '/\d{4}/m';

    /**
     * YandexResponseParser constructor.
     */
    public function __construct($config = array())
    {
        if(empty($config)) {
            $this->config = [
                'asArray' => true,
            ];
        } else {
            $this->config = $config;
        }
    }

    /**
     * @param $str Ответ от Яши
     * @return array|object
     */
    public function parse($str) {
        preg_match(self::ACCOUNT_NUMBER_EXP, $str, $matches);
        $accountNumber = $matches[0];
        $str = str_replace($accountNumber,'',$str);

        preg_match(self::SUM_EXP, $str, $matches);
        $sum = $matches[0];
        if(strstr($sum,',') !== false) {
            $sum = str_replace(',','.',$sum);
        }
        $sum = (float)$sum;

        preg_match(self::PASSWORD_EXP, $str, $matches);
        $password = $matches[0];

        $ret = [
            'sum' => $sum,
            'accountNumber' => $accountNumber,
            'password' => $password
        ];

        if(!$this->config['asArray']) {
            $ret = (object)$ret;
        }
        return $ret;
    }
}
