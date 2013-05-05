# # jared smith | http://jaredsmyth.info
# #

import sys
import soundcloud


# create a client object with your app credentials
sClient = soundcloud.Client(client_id='___YOUR_CLIENT_ID_HERE___')

# resolve track id
tID = sClient.get('/resolve', url=sys.argv[1])

# get the track from the ID
track = sClient.get('/tracks/'+str(tID.id))

# # get the tracks streaming URL
stream_url = sClient.get(track.stream_url, allow_redirects=False)

# # print the tracks stream URL
print stream_url.location