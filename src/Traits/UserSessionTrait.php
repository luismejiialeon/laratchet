<?php

namespace Barrot\Laratchet\Traits;


trait UserSessionTrait {


    /**
     * Relation for user session
     *
     * @return mixed
     */
    public function session()
    {
        return $this->hasOne('\Barrot\Laratchet\Models\Session','user_id');
    }

}