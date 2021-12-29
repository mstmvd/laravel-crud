<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

if (!function_exists('crudResponse')) {
    function crudResponse($data = null, $message = '', $status = 200, array $headers = array(), $options = 0)
    {
        if ($data instanceof Builder) {
            $params = request()->query();
            Arr::forget($params, 'page');

            $usePaginate = (request()->has('paginate') && request('paginate')) != false;
            $isCount = request()->has('count');

            if ($usePaginate) {
                $perPage = request()->has('per-page') ? request()->input('per-page') : null;
                $result = $data->paginate($perPage)->appends($params);
            } elseif ($isCount){
                $result = $data->count();
            } else {
                $result = $data->get();
            }
        } else {
            $result = $data;
        }

        $response = [
            'message' => __($message),
            'data' => $result
        ];
        return response()->json($response, $status, $headers, $options);
    }
}

if (!function_exists('quickRandom')) {

    /**
     * <b>config schema</b><br/>
     * <pre>
     * {
     *  length: int,
     *  number: bool,
     *  alphabet: bool,
     *  specialChar: bool,
     *  case: 'lower' | 'upper' | 'mixed'
     *  unique: {
     *      model: EloquentModel,
     *      column: field name of model
     *  },
     *  prefix: string
     *  postfix: string
     * }
     * </pre>
     * @param array $config
     * @return bool|string
     */
    function quickRandom($config = array())
    {
        $length = 16;
        $number = true;
        $alphabet = true;
        $specialChars = false;
        $case = 'mixed';
        $unique = null;
        $prefix = '';

        foreach ($config as $key => $value) {
            switch ($key) {
                case 'length':
                    $length = $value;
                    break;
                case 'number':
                    $number = $value;
                    break;
                case 'alphabet':
                    $alphabet = $value;
                    break;
                case 'specialChars':
                    $specialChars = $value;
                    break;
                case 'case':
                    $case = $value;
                    break;
                case 'unique':
                    $unique = $value;
                    break;
                case 'prefix':
                    $prefix = $value;
            }
        }
        $pool = '';
        $pool .= $number ? '0123456789' : '';
        $pool .= $specialChars ? '!@#$%^&*()_+-=/.,[]{}|' : '';
        if ($alphabet) {
            switch ($case) {
                case 'lower':
                    $pool .= 'abcdefghijklmnopqrstuvwxyz';
                    break;
                case 'upper':
                    $pool .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    break;
                case 'mixed':
                    $pool .= 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    break;
            }
        }

        $res = $prefix . substr(str_shuffle(str_repeat($pool, $length)), 0, $length);

        if ($unique) {
            $model = null;
            $column = null;
            if (isset($unique['model'])) {
                $model = $unique['model'];
            }
            if (isset($unique['column'])) {
                $column = $unique['column'];
            }
            if ($model === null || $column === null) {
                return false;
            }
            while ($model::where($column, $res)->count() !== 0) {
                $res = $prefix . substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
            }
        }

        return $res;
    }
}
