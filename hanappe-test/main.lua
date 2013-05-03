-- import
local modules = require "modules"
local config = require "config"



-- !J!
function onResize ( width, height )
    print("resize event: " .. width .. " x " .. height)
     -- mainViewport:setSize ( width, height )
     -- mainViewport:setScale ( width, height )
end

MOAIGfxDevice.setListener ( MOAIGfxDevice.EVENT_RESIZE, onResize )


if MOAIKeyboardAndroid ~= nil then
    print("On Android, hiding keyboard..")
    MOAIKeyboardAndroid.hideKeyboard()
end


-- start and open

Application:start(config)
SceneManager:openScene(config.mainScene)



