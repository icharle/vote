<?php
	namespace PHPSTORM_META {
	/** @noinspection PhpUnusedLocalVariableInspection */
	/** @noinspection PhpIllegalArrayKeyTypeInspection */
	$STATIC_METHOD_TYPES = [

		\D('') => [
			'Adv' instanceof Think\Model\AdvModel,
			'Mongo' instanceof Think\Model\MongoModel,
			'View' instanceof Think\Model\ViewModel,
			'Relation' instanceof Think\Model\RelationModel,
			'Img' instanceof Home\Model\ImgModel,
			'User' instanceof AdminXingkong\Model\UserModel,
			'Vote' instanceof Home\Model\VoteModel,
			'Merge' instanceof Think\Model\MergeModel,
		],
	];
}