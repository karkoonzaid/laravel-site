<?php

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

    /**
     * Create a new model.
     *
     * @param  array $input
     * @throws Exception
     * @return mixed
     */
    public static function create(array $input)
    {
        static::beforeCreate($input);

        $return = parent::create($input);

        static::afterCreate($input, $return);

        return $return;
    }

    /**
     * @param array $input
     */
    public static function beforeCreate(array $input)
    {
    }

    /**
     * @param array $input
     * @param $return
     */
    public static function afterCreate(array $input, $return)
    {
    }

    /**
     * Update an existing model.
     * @param  array $input
     * @throws Exception
     * @return mixed
     */
    public function update(array $input = [])
    {

        $this->beforeUpdate($input);

        $return = parent::update($input);

        $this->afterUpdate($input, $return);

        return $return;
    }

    /**
     * Before updating an existing new model.
     * @param  array $input
     * @return mixed
     */
    public function beforeUpdate(array $input)
    {
    }

    /**
     * After updating an existing model.
     * @param  array $input
     * @param  mixed $return
     * @return mixed
     */
    public function afterUpdate(array $input, $return)
    {
    }

    public function beforeSave(array $input)
    {
    }

    /**
     * Delete an existing model.
     *
     * @throws Exception
     * @return mixed
     */
    public function delete()
    {
        $this->beforeDelete();

        $return = parent::delete();

        $this->afterDelete($return);

        return $return;
    }

    /**
     * Before deleting an existing model.
     *
     * @return mixed
     */
    public function beforeDelete()
    {
    }

    /**
     * After deleting an existing model.
     *
     * @param  mixed $return
     * @return mixed
     */
    public function afterDelete($return)
    {
    }

    /**
     * @param $value
     * Set Price Attribute to Double
     * Match Type Case with database column type
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (double) ($value);
    }

    /*********************************************************************************************************
     * Model Scopes
     ********************************************************************************************************/
    public function scopeOfStatus($query, $status)
    {
        return $query->whereStatus($status);
    }

    public function formattedCreated()
    {
        $dt = Carbon::createFromTimestamp(strtotime($this->created_at));
        $date =  $dt->format('d-m-y \\a\\t ga'); // 05-11-2014 at 1pm
        return $date;
    }
}