SecuGen FDx SDK Pro for Java v1.3
June 3, 2013
README
================================================================


Supported Platforms
===================
Microsoft Windows
JDK v1.6.0_30
JRE Plugin v1.6.0_30


Files Included in this Distribution
===================================
readme.txt          - this file
AbsoluteLayout.jar  - Layout classes used by SWING sample
FDxSDKPro.jar       - SecuGen FDx SDK Pro for Java SDK
jnisgfplib.dll      - 32bit SecuGen FDx SDK Pro JNI library
jnisgfplib/Win32/jnisgfplib.dll - 32bit SecuGen FDx SDK Pro JNI library
jnisgfplib/x64/jnisgfplib.dll   - 64bit SecuGen FDx SDK Pro JNI library                     
doc                 - SecuGen FDxSDK for Java JavaDoc
run_JSGFPLibTest.bat- runs the JFPLibTest sample application
run_JSGD.bat        - runs the JSGD SWING sample application
run_JSGMultiDeviceTest.bat - runs the multiple device test sample
signedapplet.doc    - description of signed applet and browser test results

Release Notes
=============
v1.3 - Added JSGD Applet Demo
       Added 64bit native library
v1.2 - Added JSGD SWING example
v1.1 - Added GetImageEx method


Installation
============
1. Install FDx SDK Pro for Windows v3.54 
2. Install JDK v1.6.0_30
3. Install the FDx SDK Pro for Java runtime files
   Windows 7 32bit: Copy jnifplib\win32\jnisgfplib.dll to C:\windows\system32
   Windows 7 64bit:	Copy jnifplib\win32\jnisgfplib.dll to C:\Windows\SysWOW64
                  	Copy jnifplib\x64\jnisgfplib.dll to C:\Windows\system32



Running the Sample Applications
===============================
1. JFPLibTest
   java -cp ".;FDxSDKPro.jar" SecuGen.FDxSDKPro.samples.JSGFPLibTest


Extracting the Sample Application Source Code
=============================================
jar xvf FDxSDKPro.jar SecuGen/FDxSDKPro/samples/JSGFPLibTest.java SecuGen/FDxSDKPro/samples/JSGD.java


Building the Sample Applications
================================
javac -deprecation -classpath ".;AbsoluteLayout.jar;FDxSDK.jar" SecuGen\FDxSDKPro\samples\*.java

Building and running the Signed Applet Demo
===========================================
1. Run genkey.bat to build the keystore
2. Run buildsignedapplet.bat to build AppletDemo.jar
3. Load JSGDAppletDemo.html in browser

