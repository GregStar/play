

MOAISim.openWindow ( "mview test", 320, 480 )



viewport = MOAIViewport.new ()

viewport:setSize ( 320, 480 )

viewport:setScale ( 320, -480 )



layer = MOAILayer2D.new ()



gfxQuad = MOAIGfxQuad2D.new ()

gfxQuad:setTexture ( "moai.png" )

gfxQuad:setRect ( -128, -128, 128, 128 )

gfxQuad:setUVRect ( 0, 0, 1, 1 )



prop = MOAIProp2D.new ()

prop:setDeck ( gfxQuad )

layer:insertProp ( prop )



prop:moveRot ( 360, 10, MOAIEaseType.LINEAR )





local localRenderTable={}



local MViews={}



local function newView(option)

        local rect=option.rect

        local scale=option.scale

        local viewport=MOAIViewport.new()

        viewport:setSize(unpack(rect))

        viewport:setScale(unpack(scale))



        local camera=MOAICamera2D.new()



        local viewSwitcherDeck=MOAIScriptDeck.new()

        viewSwitcherDeck:setRect(0,0,1,1)

        viewSwitcherDeck:setDrawCallback(function()

                for j,l in ipairs(localRenderTable) do

                        l:setViewport(viewport)

                        l:setCamera(camera)

                end

        end)



        local viewSwitcher=MOAIProp.new()

        viewSwitcher:setDeck(viewSwitcherDeck)



        local view={

                switcher=viewSwitcher,

                viewport=viewport,

                camera=camera

        }

        table.insert(MViews,view)

        return view

end



local function updateMView()

        local renderTable={}

        MOAIRenderMgr.setRenderTable(renderTable)

        for i,v in ipairs(MViews) do

                 --insert view switcher first, then the layers to be rendered

                table.insert(renderTable, v.switcher)

                for j,l in ipairs(localRenderTable) do

                        table.insert(renderTable,l)

                end

        end

end





local function pushRenderLayer(l)

        table.insert(localRenderTable,l)

end



pushRenderLayer(layer)

local w,h=100,100

local sw,sh=2000,2000

local t=1

for x=0,2 do

        for y=0,3 do

        local view=newView{

                        rect={x*w,y*h,x*w+w,y*h+h},

                        scale={sw/t,-sh/t},

                }

        view.camera:moveRot(360, t)

        t=t+1

        end

end



updateMView()




