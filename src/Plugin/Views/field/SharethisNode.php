<?php

/**
 * @file
 * Contains \Drupal\history\Plugin\views\field\HistoryUserTimestamp.
 */

namespace Drupal\sharethis\Plugin\views\field;
use Drupal\views\ResultRow;
use Drupal\views\Plugin\views\field\FieldPluginBase;

/**
 * Field handler to display the number of new comments.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("sharethis_node")
 */
class SharethisNode extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $this->ensureMyTable();
    $this->addAdditionalFields();
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    $sharethis_manager = \Drupal::service('sharethis.manager');
    $node = $values->_entity;
    $mTitle = $node->getTitle();
    $mPath = $node->urlInfo();
    $mPath = $mPath->getInternalPath();
    $data_options = $sharethis_manager->getOptions();
    $content = $sharethis_manager->renderSpans($data_options, $mTitle, $mPath);
    return [
      '#theme' => 'sharethis_block',
      '#content' => $content,
      '#attached' => array(
        'library' => array(
          'sharethis/sharethispickerexternalbuttonsws',
          'sharethis/sharethispickerexternalbuttons',
        ),
      ),
    ];
  }

}
