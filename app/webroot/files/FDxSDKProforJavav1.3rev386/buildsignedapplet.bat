echo off
jar xvf FDxSDKPro.jar
jar xvf AbsoluteLayout.jar
jar xvf mysql-connector-java-5.1.6-bin.jar
javac -deprecation applet\*.java
jar cvf AppletDemo.jar SecuGen\FDxSDKPro\jni\*.class applet\*.class org\netbeans\lib\awtextra\*.* com\mysql\jdbc\*.* manifest.txt 
jar umf manifest.txt AppletDemo.jar
jarsigner -keystore demokeystore2 -storepass demopassword2 -keypass demopassword2 AppletDemo.jar demokey2

