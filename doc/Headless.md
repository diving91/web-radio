## Headless configuration of the PI zero with Raspbian image

- Download Raspbian Stretch Lite image from official repo and load it on the SD card
- In boot partition add the following line in config.txt file
```
# hifiberry mini amp
dtoverlay=hifiberry-dac
 ```

- Add a file with name 'ssh' in boot partition
- Add a file 'wpa_supplicant.conf' file in boot partition
```
ctrl_interface=DIR=/var/run/wpa_supplicant GROUP=netdev
  network={
    ssid="#your_ssid#"
    psk="#your_pwd#"
  }
 ```

- Insert the SD card in PI Zero card slot and power it up
- Connect with putty in ssh ( login: pi /password: raspberry)
- Update raspbian
> sudo apt-get update
> sudo apt-get upgrade
- Run raspi-config to configure timezone, locales, change password, ...
> sudo raspi-config
- >sudo wpa_passphrase '#your_ssid#' '#your_pwd#'
- >sudo nano /etc/wpa_supplicant/wpa_supplicant.conf

and replace psk with above provided key
```
ctrl_interface=DIR=/var/run/wpa_supplicant GROUP=netdev
  network={
    ssid="#your_ssid#"
    psk=513xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx9cb8b
  }
 ```

- mount tmp directories in ram to spare SD card
>sudo nano /etc/fstab
```
tmpfs /tmp  tmpfs defaults,noatime,nosuid,size=10m 0 0
tmpfs /var/tmp tmpfs defaults,noatime,nosuid,size=10m 0 0
# tmpfs /var/log tmpfs defaults,noatime,nosuid,mode=0755,size=10m 0 0
 ```
 - You can also mount /var/log in tmpfs, but you then loose the logs for debugging
 - Install needed additional packages
 >sudo apt-get install alsa-utils mpg123 screen nginx php7.0-fpm php7.0-curl at libttspico-utils
 - reboot
>sudo shutdown -r now

