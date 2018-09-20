<?php

namespace SysMl\Laratchet\Traits;


trait UserSessionTrait {


    /**
     * Relation for user session
     *
     * @return mixed
     */
    public function session()
    {
        return $this->hasOne('\SysMl\Laratchet\Models\Session','user_id');
    }

}