-- import
local modules = require "modules"
local config = require "config"


if MOAIKeyboardAndroid ~= nil then
    print("On Android, hiding keyboard..")
    MOAIKeyboardAndroid.hideKeyboard()
end


-- start and open
Application:start(config)
SceneManager:openScene(config.mainScene)
