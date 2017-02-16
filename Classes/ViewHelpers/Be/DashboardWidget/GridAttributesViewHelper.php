<?php
namespace TYPO3\CMS\Dashboard\ViewHelpers\Be\DashboardWidget;

/*                                                                        *
 * This script is backported from the TYPO3 Flow package "TYPO3.Fluid".   *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 *  of the License, or (at your option) any later version.                *
 *                                                                        *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

class GridAttributesViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Be\AbstractBackendViewHelper
{
    /**
     * Returns grid item attributes
     *
     * @param \TYPO3\CMS\Dashboard\Domain\Model\DashboardWidgetSettings $widgetSetting
     * @param int $index
     * @param string $className
     * @return string Path to icon if ok, else fallback
     */
    public function render($widgetSetting, $index, $className = 'grid-item')
    {
        $widgetIdentifier = $widgetSetting->getWidgetIdentifier();
        $widget = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['dashboard']['widgets'][$widgetIdentifier];
        list($width, $height) = explode('x', $widget['size']);
        $width = $this->getItemWidth((int)$width);
        $height = $this->getItemHeight((int)$height);

        $attributes = 'class="' . $className . ' col-md-' . ($width * 4) . ' height-' . $height . '"' .
            ' data-id="' . $widgetIdentifier . '-' . $widgetSetting->getUid() . '"'.
            ' data-w="' . $width . '" data-h="' . $height. '"';

        // NOTE: x=column, y=row (e.g 2x2 grid = 0x0,0x1,1x0,1x1)
        if ($index < 3) {
            $col = $index;
            $row = 0;
        } else {
            $col = $index % 3;
            $row = intval($index / 3);
        }
        $attributes .= ' data-x="' . $col . '" data-y="' . $row . '"';
        return $attributes;
    }

    /**
     * @param int $width
     * @return string css class name
     */
    protected function getItemWidth($width)
    {
        if ($width >= 3) {
            $validWith = 3;
        } elseif ($width) {
            $validWith = $width;
        } else {
            $validWith = 1;
        }
        return $validWith;
    }

    /**
     * @param int $height
     * @return string css class name
     */
    protected function getItemHeight($height)
    {
        if ($height >= 3) {
            $validHeight = 3;
        } elseif ($height) {
            $validHeight = $height;
        } else {
            $validHeight = 1;
        }
        return $validHeight;
    }
}
