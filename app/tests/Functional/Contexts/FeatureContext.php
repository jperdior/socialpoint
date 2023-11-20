<?php

declare(strict_types=1);

namespace Tests\Functional\Contexts;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use SP\Infrastructure\Http\Kernel;
use SP\Infrastructure\Http\Request;
use SP\Infrastructure\Response;

require 'data/dataset/dataset.php';

class FeatureContext implements Context
{
    private Response $response;

    private Kernel $kernel;

    public function __construct()
    {
        $this->kernel = Kernel::createWithDataSet(rankingDataSet());
    }

    public function runRequest(string $method, string $uri, array $queryString, string $body)
    {
        $request = new Request(
            $uri,
            $method,
            $queryString,
            $body
        );
        $response = $this->kernel->run($request);
        $this->response = $response;
    }

    /**
     * @When /^Ask for a "([^"]*)" ranking$/
     */
    public function askForARanking(string $top): void
    {
        $url = "/ranking";
        $params = [
            'type' => $top
        ];

        $this->runRequest('GET', $url, $params, '');
        $statusCode = $this->response->getStatusCode();
        if ($statusCode != 200) {
            throw new \Exception('Expected a 200, but received a ' . $statusCode);
        }
    }

    /**
     * @Then /^The absolute "([^"]*)" ranking is returned$/
     */
    public function theAbsoluteRankingIsReturned(string $top): void
    {
        $expectedLen = (int)(substr($top, strlen('top')));

        $responseBody = json_decode($this->response->getBody(), true);
        if ($responseBody == '') {
            throw new \Exception('Expected a response body but get an empty body');
        }

        $responseData = $responseBody["data"];
        $totalRanking = count($responseData);

        if ($expectedLen != $totalRanking) {
            throw new \Exception(sprintf("Expected a ranking of %d, but received %d elements", $expectedLen, $totalRanking));
        }

        $ranking = $this->sortedDataSet();
        $rankingSlice = array_slice($ranking, 0, $expectedLen);

        if ($rankingSlice != $responseData) {
            throw new \Exception(sprintf("Expected %s got %s",
                print_r($rankingSlice, true),
                print_r($responseData, true),
            ));
        }
    }

    /**
     * @Then /^The relative "([^"]*)" ranking is returned$/
     */
    public function theRelativeRankingIsReturned(string $top)
    {
        $responseBody = json_decode($this->response->getBody(), true);
        $responseData = $responseBody["data"];

        $relativeSets = [
            "At5/2"   => [
                '01H5MSZ9MA1EGE0ZY366KP763N' => 9612,
                '01H5MSZ9MAT2V38T6R51TM11JQ' => 9473,
                '01H5MSZ9MA9JS2WRNA5DREYQTD' => 9433,
                '01H5MSZ9MBFR124JWVRYCH20KR' => 9254,
                '01H5MSZ9MBHAV430G6XMH855TZ' => 9206,
            ],
            "At10/3"  => [
                '01H5MSZ9MBHAV430G6XMH855TZ' => 9206,
                '01H5MSZ9MCC94JDM3FVWC16CZM' => 9089,
                '01H5MSZ9MC3ZJNZEGX1CXGNV6D' => 9054,
                '01H5MSZ9MCGYARGQK73P9CECCF' => 8739,
                '01H5MSZ9MD9Y23GVDH461AYGN4' => 8733,
                '01H5MSZ9MDQ4KKQHHJ2VYPGSDZ' => 8563,
                '01H5MSZ9MDVA4J3RFJXNXF8045' => 8498,
            ],
            "At100/1" => [
                '01H5MSZ9N747DK584VAKVZKQRV' => 350,
                '01H5MT1DQ04J1PRE1MXKR4VTPC' => 268
            ],
        ];

        if ($relativeSets[$top] != $responseData) {
            throw new \Exception(sprintf("Expected %s got %s",
                print_r($relativeSets[$top], true),
                print_r($responseData, true),
            ));
        }
    }

    /**
     * @When /^Request with body (.*) for the user id (.*) is received$/
     */
    public function requestWithBodyForTheUserIdIsReceived(string $requestBody, string $userId)
    {
        $url = sprintf("/user/%s/score", $userId);

        $this->runRequest('POST', $url, [], $requestBody);
        $statusCode = $this->response->getStatusCode();
        if ($statusCode != 200) {
            throw new \Exception('Expected a 200, but received a ' . $statusCode);
        }
    }

    /**
     *  @Then /^The score for the user with id (.*) should be (.*)$/
     */
    public function theScoreOfTheUserShouldBe(string $userId, int $expectedScore)
    {
        $this->askForARanking("top100");
        $statusCode = $this->response->getStatusCode();
        if ($statusCode != 200) {
            throw new \Exception('Expected a 200, but received a ' . $statusCode.' when ask for the ranking');
        }

        $responseBody = json_decode($this->response->getBody(), true);
        if ($responseBody == '') {
            throw new \Exception('Expected a response body but get an empty body');
        }
        $responseData = $responseBody["data"];

        $gotScore = $responseData[$userId];

        if ($expectedScore != $gotScore) {
            throw new \Exception(sprintf("Expected %s got %s",
                print_r($expectedScore, true),
                print_r($gotScore, true),
            ));
        }
    }

    private function sortedDataSet(): array
    {
        return [
            '01H5MSZ9M9E5Y0A26REDGNPJY7' => 9966,
            '01H5MSZ9M97H257CX7G7AGVCSJ' => 9758,
            '01H5MSZ9MA1EGE0ZY366KP763N' => 9612,
            '01H5MSZ9MAT2V38T6R51TM11JQ' => 9473,
            '01H5MSZ9MA9JS2WRNA5DREYQTD' => 9433,
            '01H5MSZ9MBFR124JWVRYCH20KR' => 9254,
            '01H5MSZ9MBHAV430G6XMH855TZ' => 9206,
            '01H5MSZ9MCC94JDM3FVWC16CZM' => 9089,
            '01H5MSZ9MC3ZJNZEGX1CXGNV6D' => 9054,
            '01H5MSZ9MCGYARGQK73P9CECCF' => 8739,
            '01H5MSZ9MD9Y23GVDH461AYGN4' => 8733,
            '01H5MSZ9MDQ4KKQHHJ2VYPGSDZ' => 8563,
            '01H5MSZ9MDVA4J3RFJXNXF8045' => 8498,
            '01H5MSZ9MEA01P83R5XC05MZ3Y' => 8382,
            '01H5MSZ9METNFDXXDYHWNCA3R4' => 8209,
            '01H5MSZ9MEVD5F0HPJ8VQDYWBD' => 8134,
            '01H5MSZ9MF25FDZ2F2NYWSPMSJ' => 8128,
            '01H5MSZ9MF2VST8AH0SMSMY8B8' => 8114,
            '01H5MSZ9MF7ANZANBA1VPTHV2E' => 7912,
            '01H5MSZ9MG83PRTNSVJ4D28P0T' => 7906,
            '01H5MSZ9MG9WFP8P0433WRXR0P' => 7845,
            '01H5MSZ9MGGT13RMHF3PSMVP65' => 7501,
            '01H5MSZ9MH4D8FCXD539278MPQ' => 7476,
            '01H5MSZ9MH3AT1YQ76M0EG7Z4P' => 7475,
            '01H5MSZ9MH1DZA8RN0BCYDGFH7' => 7444,
            '01H5MSZ9MHSZ0PPM4200XF3BNN' => 7357,
            '01H5MSZ9MJX8EZ1C267B8E1RWR' => 7330,
            '01H5MSZ9MJ1F9RERNWM82BNBMP' => 7292,
            '01H5MSZ9MJVJYWY5JXH4TZJV7W' => 7289,
            '01H5MSZ9MK1AQC2WG6J108368K' => 7276,
            '01H5MSZ9MKP72GH7CMK44GV4Z4' => 7275,
            '01H5MSZ9MK0Z3SDYA3MN0RYZTF' => 7179,
            '01H5MSZ9MMVNMT8Q4J7GPREJ8N' => 7008,
            '01H5MSZ9MMV3P8H945BA5SZE5W' => 6920,
            '01H5MSZ9MMS8V44N6MMTWXM543' => 6906,
            '01H5MSZ9MN701MFHF7YXY57B2Y' => 6850,
            '01H5MSZ9MNSKAX6199G78KB9GC' => 6777,
            '01H5MSZ9MN6M629T7EB2586N9W' => 6569,
            '01H5MSZ9MPK1GWX0Z0T1EKWZYH' => 6539,
            '01H5MSZ9MPKXNPJZ17JWSGK5TS' => 6510,
            '01H5MSZ9MPZ0K2S7KWR32JYDPM' => 6386,
            '01H5MSZ9MQR7VBJHM90D9S8H0D' => 5981,
            '01H5MSZ9MQQM3AQNB3JABTZRG1' => 5900,
            '01H5MSZ9MQ9F2N0M4ZQR23GW8Q' => 5820,
            '01H5MSZ9MQKZH92M6X6JFMYTNQ' => 5729,
            '01H5MSZ9MR2BJY5YV5QXFRFJ4R' => 5688,
            '01H5MSZ9MRK8FNQC2X48Z6FWX4' => 5506,
            '01H5MSZ9MRWJGAE1VZCWC490ZA' => 5398,
            '01H5MSZ9MSWG745T52PS7SBSMT' => 5392,
            '01H5MSZ9MSZ3RD1SNHR4ETK3BM' => 5358,
            '01H5MSZ9MS133ZVJWKW6W12HV5' => 5310,
            '01H5MSZ9MS22QP599BR1T3VR9R' => 5294,
            '01H5MSZ9MT29EEJP352B9QAY71' => 5270,
            '01H5MSZ9MTT8029ESXN6XZJN22' => 5201,
            '01H5MSZ9MTZEDZ6Y0K9A1XQKZY' => 5066,
            '01H5MSZ9MTNWKCA00GFAEJPSEQ' => 5053,
            '01H5MSZ9MVVFCKET2RT89KG5R0' => 4997,
            '01H5MSZ9MVDCWF02B2583EBZKH' => 4973,
            '01H5MSZ9MVCZQPC460GZ49AFV5' => 4947,
            '01H5MSZ9MW40KSEWKSZQESW93W' => 4923,
            '01H5MSZ9MW7WJW5P4WA5FK30CH' => 4886,
            '01H5MSZ9MW5GG716DS6XVAJTA9' => 4871,
            '01H5MSZ9MWGXZ82FR5RQZY6ND0' => 4841,
            '01H5MSZ9MX6R992J6SNBKNZ9DK' => 4832,
            '01H5MSZ9MX92AQDWXNX0KVHRHA' => 4775,
            '01H5MSZ9MXHMYCRQ0A106KF04T' => 4770,
            '01H5MSZ9MXTMCS1093JNVH4841' => 4742,
            '01H5MSZ9MY4QDRWPV3CE1JGBWE' => 4581,
            '01H5MSZ9MY12CMFF88JA8YP3K1' => 4156,
            '01H5MSZ9MY9D46WNSY9K4WGVWD' => 4106,
            '01H5MSZ9MZNS4N2F1YSY4ZERAY' => 4102,
            '01H5MSZ9MZZSCM2M9BNACZGQ63' => 3981,
            '01H5MSZ9MZZE7CS8X0TJANRC1Z' => 3806,
            '01H5MSZ9MZKNT1EFRE674DR5D0' => 3682,
            '01H5MSZ9N0BQN5GC5FZDP25A9D' => 3577,
            '01H5MSZ9N0Z3TSNMS1YZH7JV3V' => 3573,
            '01H5MSZ9N079WE8Z3KTKNRBGAX' => 2648,
            '01H5MSZ9N1HJ71MBAT8KSM1868' => 2580,
            '01H5MSZ9N199RBN5CB6TYRK6TB' => 2465,
            '01H5MSZ9N134FCA33GESGJFJH1' => 2296,
            '01H5MSZ9N1NNGPE5TWAY1V5106' => 2204,
            '01H5MSZ9N27EK93W03WPB9398A' => 2202,
            '01H5MSZ9N25SYDNHMD2J6PRR6D' => 2101,
            '01H5MSZ9N2GQ5C3H2ZJR82RCQC' => 2063,
            '01H5MSZ9N2JFMWQQT3PZ915A3Q' => 2026,
            '01H5MSZ9N3R7JPH65HXJH3QA6P' => 2016,
            '01H5MSZ9N4EKH0MZ3RRBDRZ5WA' => 1985,
            '01H5MSZ9N4CSPPYN5VM67F47FY' => 1703,
            '01H5MSZ9N4CA3ZXH0SSA5VXQZX' => 1679,
            '01H5MSZ9N4ESSV8T1ATFSB02VP' => 1541,
            '01H5MSZ9N5099KE9S2HNHPMEPY' => 1530,
            '01H5MSZ9N5KBJCHFR3X284H471' => 1123,
            '01H5MSZ9N5RFCCWV5PHN0KX8VD' => 1070,
            '01H5MSZ9N5ZQ90XER7YEBDB07E' => 1030,
            '01H5MSZ9N69PQSRKWV254TJJNP' => 507,
            '01H5MSZ9N6E0VM2Y4PPKKDS83N' => 372,
            '01H5MSZ9N64F5FQBXE2Y4KSK7R' => 371,
            '01H5MSZ9N7SDAZV0WA4XTWHDJ9' => 357,
            '01H5MSZ9N747DK584VAKVZKQRV' => 350,
            '01H5MT1DQ04J1PRE1MXKR4VTPC' => 268,
        ];
    }
}
