## Configure audio

### Check HifiBerry is well configured
- Check the sound card
> aplay -l

You should see an entry
```
card 1: sndrpihifiberry [snd_rpi_hifiberry_dac], device 0: HifiBerry DAC HiFi pcm5102a-hifi-0 []
```
> cat /proc/asound/modules

You should have
```
 0 snd_bcm2835
 1 snd_soc_hifiberry_dac
```

- Test it's working

>speaker-test -t sine -f 440
### Configure asound 
-  Configure default card, soft volume & mixing to mono channel
>sudo nano /etc/asound.conf
```
defaults.ctl.card 1
defaults.pcm.card 1
defaults.timer.card 1

# Add Softvol and Downmix mono by default
pcm.!default {
	type plug
	slave.pcm hifiberry
}

# Downmix Stereo to Mono
pcm.makemono {
	type route
	slave.pcm "plughw:1,0"
	ttable {
		0.0 1  # in-channel 0, out-channel 0, 100% volume
		1.0 1  # in-channel 1, out-channel 0, 100% volume
	}
}

# Soft Volume
pcm.hifiberry {
	type softvol
	slave.pcm "makemono"
	control.name "Volume"
	control.card 1
}
```
- Some additional tests
>speaker-test -t sine -f 440
>speaker-test -t wav -c 2

with -c 2 you check that stereo is well mixed down to mono channel
>aplay /usr/share/sounds/alsa/Front_Right.wav
>mpg123 #your file#.mp3
>mpg123 [http://stream.chantefrance.com/stream_chante_france.mp3](http://stream.chantefrance.com/stream_chante_france.mp3)

- Define audio volume
>amixer sset Volume 30%
>alsamixer

