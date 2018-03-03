<?php

trait ActionTrait
{
    public function getAction()
    {
        $currentRoute = Route::getCurrentRoute();
        $uri = explode('\\', $currentRoute->getActionName());
        $action = $uri[count($uri) - 1];
        $parameters = $currentRoute->parameters();

        if (!empty($parameters)) {
            $parameterName = $currentRoute->parameterNames()[0];
            $actionParameterId = (!empty($parameters[$parameterName]->id)) ? $parameters[$parameterName]->id : null;
        } else {
            $actionParameterId = null;
        }
        list($controller, $function) = explode('@', $action);

        return [
            'actionController'  => str_replace('controller', '', strtolower($controller)),
            'actionFunction'    => strtolower($function),
            'actionParameterId' => $actionParameterId,
        ];
    }

    public function getActionController()
    {
        $result = $this->getAction();

        return $result['actionController'];
    }

    public function getActionFunction()
    {
        $result = $this->getAction();

        return $result['actionFunction'];
    }

    public function isAction($controller, $function)
    {
        $action = $this->getAction();

        if (is_array($function)) {
            return ($action['actionController'] == strtolower($controller) && in_array($action['actionFunction'], $function));
        } else {
            return ($action['actionController'] == strtolower($controller) && $action['actionFunction'] == strtolower($function));
        }
    }

}
