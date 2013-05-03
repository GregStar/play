-- MOAISim setting
MOAISim.setStep ( 1 / 60 )
MOAISim.clearLoopFlags ()
MOAISim.setLoopFlags ( MOAISim.SIM_LOOP_ALLOW_BOOST )
MOAISim.setLoopFlags ( MOAISim.SIM_LOOP_LONG_DELAY )
MOAISim.setBoostThreshold ( 0 )

-- Text Label
TextLabel.DEFAULT_COLOR = {0, 0, 0, 1}

-- Screen size setting
local screenWidth = MOAIEnvironment.horizontalResolution or 320
local screenHeight = MOAIEnvironment.verticalResolution or 480
local viewScale = screenWidth >= 640 and 2 or 1

local screen_resolutions = {} -- w,h,dpi
screen_resolutions["iOS iPhone / iPod Touch"] = { 480,320,163 };
screen_resolutions["iOS iPhone / iPod Touch Retina"] = { 960,640,326 };
screen_resolutions["iOS iPad"] = { 1024,768,132 };
screen_resolutions["iOS iPad Retina"] = { 2048,1536,264 };
screen_resolutions["Android small-ldpi QVGA"] = { 240,320,120 };
screen_resolutions["Android normal-ldpi WQVGA400"] = { 240,400,120 };
screen_resolutions["Android normal-ldpi WQVGA432"] = { 240,432,120 };
screen_resolutions["Android large-ldpi WVGA800"] = { 480,800,120 };
screen_resolutions["Android large-ldpi WVGA854"] = { 480,854,120 };
screen_resolutions["Android xlarge-ldpi 1024x600"] = { 1024,600,120 };
screen_resolutions["Android normal-mdpi HVGA"] = { 320,480,160 };
screen_resolutions["Android large-mdpi WVGA800"] = { 480,800,160 };
screen_resolutions["Android large-mdpi WVGA854"] = { 480,854,160 };
screen_resolutions["Android large-mdpi 600x1024"] = { 600,1024,160 };
screen_resolutions["Android xlarge-mdpi WXGA"] = { 1280,800,160 };
screen_resolutions["Android xlarge-mdpi 1024x768"] = { 1024,768,160 };
screen_resolutions["Android xlarge-mdpi 1280x768"] = { 1280,768,160 };
screen_resolutions["Android small-hdpi 480x640"] = { 480,640,240 };
screen_resolutions["Android normal-hdpi WVGA800"] = { 480,800,240 };
screen_resolutions["Android normal-hdpi WVGA854"] = { 480,854,240 };
screen_resolutions["Android normal-hdpi 600x1024"] = { 600,1024,240 };
screen_resolutions["Android xlarge-hdpi 1536x1152"] = { 1536,1152,240 };
screen_resolutions["Android xlarge-hdpi 1920x1152"] = { 1920,1152,240 };
screen_resolutions["Android xlarge-hdpi 1920x1200"] = { 1920,1200,240 };
screen_resolutions["Android normal-xhdpi 640x960"] = { 640,960,320 };
screen_resolutions["Android xlarge-xhdpi 2048x1536"] = { 2048,1536,320 };
screen_resolutions["Android xlarge-xhdpi 2560x1536"] = { 2560,1536,320 };
screen_resolutions["Android xlarge-xhdpi 2560x1600"] = { 2560,1600,320 };

-- Application config
local config = {

    title = "Dynlab Hanappe Test",
    screenWidth = screenWidth,
    screenHeight = screenHeight,
    viewScale = viewScale,
    mainScene = "main_scene",

}

return config