<?php

namespace Drupal\search_api_solr\Tests\Unit;

use Drupal\search_api_solr\Plugin\search_api\backend\SearchApiSolrBackend;
use Drupal\Tests\search_api_solr\InvokeMethodTrait;
use Drupal\Tests\UnitTestCase;
use Solarium\QueryType\Update\Query\Document\Document;

/**
 * Tests functionality of the backend.
 *
 * @coversDefaultClass \Drupal\search_api_solr\Plugin\search_api\backend\SearchApiSolrBackend
 *
 * @group search_api_solr
 */
class SearchApiBackendUnitTest extends UnitTestCase  {

  use InvokeMethodTrait;

  /**
   * @covers       ::addIndexField
   *
   * @dataProvider addIndexFieldDataProvider
   *
   * @param mixed $input
   *   Field value.
   *
   * @param string $type
   *   Field type.
   *
   * @param mixed $expected
   *   Expected result.
   */
  public function testIndexField($input, $type, $expected) {
    $field = 'testField';
    $document = $this->prophesize(Document::class);
    $document
      ->addField($field, $expected)
      ->shouldBeCalled();

    $backend = $this->prophesize(SearchApiSolrBackend::class);

    $args = [
      $document->reveal(),
      $field,
      [$input],
      $type
    ];

    $this->invokeMethod($backend, 'addIndexField', $args);
  }

  /**
   * Data provider for testIndexField method. Set of values can be extended to
   * check other field types and values.
   *
   * @return array
   */
  public function addIndexFieldDataProvider() {
    return [
      ['2016-05-25T14:00:00+10', 'date', '2016-05-25T04:00:00Z']
    ];
  }

}
