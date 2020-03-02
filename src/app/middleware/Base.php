<?php
declare (strict_types = 1);

namespace lvtu\appdemo\middleware;

class Base
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        /**
         * 鉴权(no_login,no_check不用鉴权)
         */
        $rule_mark = $request->route('rule');
        $method = $request->method();
        if(!in_array($rule_mark,['no_login','no_check']) && 0){
            $res = app()->pull('app\server\AdminAuth')->ruleCheck($method,$rule_mark);
            //如果检测不通过，直接返回检测结果
            if(!$res['succ']){
                if(isReqPage()){
                    return view('admin_error/403');
                }else{
                    return json(array('succ'=>false,'error_code'=>$res['error_code'],'msg'=>$res['msg']));
                }
            }
        }
        
        return $next($request);
    }
}
