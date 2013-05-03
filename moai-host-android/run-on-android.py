import sys
import os

DIR_MOAI_HOST = "/Users/chris/Tools/moai-host-android"

if len(sys.argv) < 2:
  print "Use: %s <luafile>" % sys.argv[0]
  exit(1)

fn = sys.argv[1]
if not os.path.isfile(fn):
  print "%s not found" % fn
  exit(2)

print "dir: ", os.path.dirname(sys.argv[1])
print "file:", os.path.basename(sys.argv[1])

with open("settings-global.blueprint") as f1:
  with open("settings-global.sh", "w") as f2:
    content = f1.read().replace("--LUAFILE--", os.path.basename(sys.argv[1]))
    f2.write(content)

with open("settings-local.blueprint") as f1:
  with open("settings-local.sh", "w") as f2:
    content = f1.read().replace("--DIR--", os.path.dirname(sys.argv[1]))
    f2.write(content)

os.system("cd %s && ./run-host.sh" % DIR_MOAI_HOST)


