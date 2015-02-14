<?php

    namespace kyra\common;

    use Yii;
    use yii\db\ActiveRecord;
    use yii\db\Exception;

    class GalleryHelper
    {
        public function RemoveImage($oid, $iid, ActiveRecord $activeRecord, $objParam='OID', $lineParam='IID')
        {
            $data = $activeRecord->find([$objParam => $oid, $lineParam => $iid])->with('image')->one();
            if(empty($data)) return false;

            $data->delete();
            return array_merge($data->attributes, $data->image->attributes);
        }

        public function ChangeOrder($oid, $order, ActiveRecord $activeRecord, $objParam='OID', $lineParam='IID', $sortParam='SortOrder')
        {
            $db = $activeRecord->getDb();
            $transaction = $db->beginTransaction();
            try
            {
                $sql = 'UPDATE '.$activeRecord->tableName().' SET '.$sortParam.'=0 WHERE '.$objParam.'=:id';
                $db->createCommand($sql, [':id' => intVal($oid)])->execute();

                if(is_array($order))
                {
                    $sql = 'UPDATE '.$activeRecord->tableName().' SET '.$sortParam.'=:i WHERE '.$objParam.'=:id AND '.$lineParam.'=:iid';
                    $i = 0;
                    foreach($order as $oi)
                    {
                        $db->createCommand($sql, [':i' => $i, ':id' => $oid, ':iid' => $oi])->execute();
                        $i++;
                    }
                }

                $transaction->commit();
                return true;
            }
            catch(Exception $ex)
            {
                $transaction->rollBack();
                return false;
            }
        }

        public function AddImage($oid, $iid, $ar, $objectParam='OID', $lineParam='IID')
        {
            $ar = Yii::createObject($ar);
            $ar->$objectParam = $oid;
            $ar->$lineParam = $iid;
            $ar->SortOrder = 999999;

            $ret = $ar->save(false);
            return $ret;
        }

        public function SetMainImage($oid, $iid, $ar, $headerImage='HeaderIID')
        {
            $ar = Yii::createObject($ar);
            $data = $ar->findOne($oid);
            $data->$headerImage = $iid;
            $ret = $data->update(false);
            return $ret;
        }
    }