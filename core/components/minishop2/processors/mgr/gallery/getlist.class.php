<?php
/**
 * Get a list of Products Files
 *
 * @package minishop2
 * @subpackage processors
 */
class msProductFileGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'msProductFile';
	public $defaultSortField = 'rank';
	public $defaultSortDirection  = 'ASC';
	public $languageTopics = array('default','minishop2:product');


	public function prepareQueryBeforeCount(xPDOQuery $c) {
		$c->where(array('product_id' => $this->getProperty('product_id')));

		$parent = $this->getProperty('parent');
		if ($parent !== false) {
			$c->where(array('parent' => $parent));
		}

		return $c;
	}


	public function prepareRow(xPDOObject $object) {
		/* @var msProductFile $object */
		$row = $object->toArray();

		if ($row['type'] != 'image') {
			$row['thumbnail'] = (file_exists(MODX_ASSETS_PATH . 'components/minishop2/img/mgr/extensions/'.$row['type'].'.png'))
				? MODX_ASSETS_URL . 'components/minishop2/img/mgr/extensions/'.$row['type'].'.png'
				: MODX_ASSETS_URL . 'components/minishop2/img/mgr/extensions/other.png';
		}
		else {
			$tmp = $object->getFirstThumbnail();
			$row['thumbnail'] = !empty($tmp['url'])
				? $tmp['url']
				: MODX_ASSETS_URL . 'components/minishop2/img/mgr/ms2_small.png';
		}

		return $row;
	}

}

return 'msProductFileGetListProcessor';