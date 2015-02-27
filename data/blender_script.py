import bpy;
import math;
cameras = ["SE","E","NE","N","NW","W","SW","S"]
path = "D:/Hobby/vkGame/sketches/game/test/"
bpy.data.scenes["Scene"].frame_current = 1;
STEP = 13
COUNT = 17

bpy.data.scenes["Scene"].camera = bpy.data.objects['SW'];

for object in bpy.data.groups['Group'].objects:
    bpy.context.scene.objects.active = object
    object.select = True

j = 0;

while j < 8:
    i = 0
    while i < COUNT:
#        bpy.data.scenes["Scene"].camera = bpy.data.objects[camera]
        bpy.data.scenes["Scene"].frame_current = i * STEP + 1
        bpy.ops.render.render()
        bpy.ops.render.view_show()
        bpy.data.images['Render Result'].save_render(path + "/" + str(j) + "/" + str(i) + ".png")
        i += 1
    j += 1
    bpy.ops.transform.rotate(value=-math.pi/4,constraint_axis=(False,False,True))
    