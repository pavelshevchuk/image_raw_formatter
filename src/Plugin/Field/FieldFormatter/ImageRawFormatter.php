<?php
/**
 * @file
 * Contains \Drupal\image_raw_formatter\Plugin\Field\FieldFormatter\ImageRawFormatter.
 */

namespace Drupal\image_raw_formatter\Plugin\Field\FieldFormatter;

use \Drupal\Core\Field\FieldItemListInterface;
use \Drupal\Core\Field\FormatterBase;
use \InvalidArgumentException;

/**
 * Plugin implementation of the 'vimeo_default' formatter.
 *
 * @FieldFormatter(
 *   id = "vimeo_default",
 *   label = @Translation("Vimeo Media"),
 *   field_types = {
 *     "text"
 *   }
 * )
 */
class ImageRawFormatter extends ImageFormatter
{

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $image_styles = image_style_options(FALSE);
    $element['image_style'] = array(
      '#title' => t('Image style'),
      '#type' => 'select',
      '#default_value' => $this->getSetting('image_style'),
      '#empty_option' => t('None (original image)'),
      '#options' => $image_styles,
    );

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();

    $image_styles = image_style_options(FALSE);
    // Unset possible 'No defined styles' option.
    unset($image_styles['']);
    // Styles could be lost because of enabled/disabled modules that defines
    // their styles in code.
    $image_style_setting = $this->getSetting('image_style');
    if (isset($image_styles[$image_style_setting])) {
      $summary[] = t('Image style: @style', array('@style' => $image_styles[$image_style_setting]));
    }
    else {
      $summary[] = t('Original image');
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $elements = array();

    $image_style_setting = $this->getSetting('image_style');

    // Collect cache tags to be added for each item in the field.
    $cache_tags = array();
    if (!empty($image_style_setting)) {
      $image_style = entity_load('image_style', $image_style_setting);
      $cache_tags = $image_style->getCacheTag();
    }

    foreach ($items as $delta => $item) {
      if ($item->entity) {
        $image_uri = $item->entity->getFileUri();
        $elements[$delta] = file_create_url($image_uri);
      }
    }

    return $elements;
  }
}
