/*
 * JSGDApplet.java
 *
 * Created on December 15, 2011, 12:51 PM
 */

package applet;


import SecuGen.FDxSDKPro.jni.*;
import java.applet.*;
import java.awt.*;
import java.awt.image.*;
import java.awt.event.*; 
import javax.swing.*;


/** DRMHOPE */
import java.io.*;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import javax.xml.bind.DatatypeConverter;
import java.net.*;
import java.util.Date;
import java.text.DateFormat;
import java.text.SimpleDateFormat;

import java.sql.Timestamp;
import java.text.SimpleDateFormat;
import java.util.Calendar;







/**/

/**
 *
 * @author  Administrator
 */
public class JSGDApplet extends javax.swing.JApplet {
    
    //Private instance variables
    private long deviceName;
    private long devicePort;
    private JSGFPLib fplib = null;  
    private long ret;
    private boolean bLEDOn;
    private byte[] regMin1 = new byte[400];
    private byte[] regMin2 = new byte[400];
    private byte[] vrfMin  = new byte[400];
    private SGDeviceInfoParam deviceInfo = new SGDeviceInfoParam();
    private BufferedImage imgRegistration1;
    private BufferedImage imgRegistration2;
    private BufferedImage imgVerification;
    private boolean r1Captured = false;
    private boolean r2Captured = false;
    private boolean v1Captured = false;
	public Connection conn = null;
	public Statement stmt = null;
	public Connection connect()
	{
		try{
                Class.forName("com.mysql.jdbc.Driver");
                
				DriverManager.setLoginTimeout(50);
				
			     conn = DriverManager.getConnection("jdbc:mysql://192.168.1.5/db_hope" ,"hopeattendance","password");
			   // conn = DriverManager.getConnection("jdbc:mysql://166.62.102.30:3306/db_lifespring" ,"fingerprint","finger@drm");
	                    
                	}catch(Exception exception){
                		exception.printStackTrace();
                	}
	 return conn;
	}
	//String parameter1 = getParameter("Message"); 
	
	
   
   
    /** Creates new form JSGD */
	
    public JSGDApplet() {
		Connection conn = null;
        bLEDOn = false;
        initComponents();
		conn=connect();
		
       // disableControls();
		
        this.jComboBoxRegisterSecurityLevel.setSelectedIndex(4);
        this.jComboBoxVerifySecurityLevel.setSelectedIndex(4);
			
		//for initializing device
		
		int selectedDevice = jComboBoxDeviceName.getSelectedIndex();
        switch(selectedDevice)
        {
            case 0: //USB
            default:
                this.deviceName = SGFDxDeviceName.SG_DEV_AUTO;
                break;
            case 1: //FDU04
                this.deviceName = SGFDxDeviceName.SG_DEV_FDU04;
                break;
            case 2: //CN_FDU03
                this.deviceName = SGFDxDeviceName.SG_DEV_FDU03;
                break;
            case 3: //CN_FDU02
                this.deviceName = SGFDxDeviceName.SG_DEV_FDU02;
                break;
        }
        fplib = new JSGFPLib();
        
        ret = fplib.Init(this.deviceName);
        if ((fplib != null) && (ret  == SGFDxErrorCode.SGFDX_ERROR_NONE))
        {
            this.jLabelStatus.setText("JSGFPLib Initialization Success");
            this.devicePort = SGPPPortAddr.USB_AUTO_DETECT;
            switch (this.jComboBoxUSBPort.getSelectedIndex())
            {
                case 1:
                case 2:
                case 3:
                case 4:
                case 5:
                case 6:
                case 7:
                case 8:
                case 9:
                case 10:
                    this.devicePort = this.jComboBoxUSBPort.getSelectedIndex() - 1;
                    break;
            }
            ret = fplib.OpenDevice(devicePort);
            if (ret == SGFDxErrorCode.SGFDX_ERROR_NONE)
            {
                this.jLabelStatus.setText("Device Ready"); 
                 				
                ret = fplib.GetDeviceInfo(deviceInfo);
                if (ret == SGFDxErrorCode.SGFDX_ERROR_NONE)
                {
                    this.jTextFieldSerialNumber.setText(new String(deviceInfo.deviceSN()));
                    this.jTextFieldBrightness.setText(new String(Integer.toString(deviceInfo.brightness)));
                    this.jTextFieldContrast.setText(new String(Integer.toString((int)deviceInfo.contrast)));
                    this.jTextFieldDeviceID.setText(new String(Integer.toString(deviceInfo.deviceID)));
                    this.jTextFieldFWVersion.setText(new String(Integer.toHexString(deviceInfo.FWVersion)));
                    this.jTextFieldGain.setText(new String(Integer.toString(deviceInfo.gain)));
                    this.jTextFieldImageDPI.setText(new String(Integer.toString(deviceInfo.imageDPI)));
                    this.jTextFieldImageHeight.setText(new String(Integer.toString(deviceInfo.imageHeight)));
                    this.jTextFieldImageWidth.setText(new String(Integer.toString(deviceInfo.imageWidth)));
                    imgRegistration1 = new BufferedImage(deviceInfo.imageWidth, deviceInfo.imageHeight, BufferedImage.TYPE_BYTE_GRAY);
                    imgRegistration2 = new BufferedImage(deviceInfo.imageWidth, deviceInfo.imageHeight, BufferedImage.TYPE_BYTE_GRAY);
                    imgVerification = new BufferedImage(deviceInfo.imageWidth, deviceInfo.imageHeight, BufferedImage.TYPE_BYTE_GRAY);
                    this.enableControls();
					this.disableControls();
					//conn=connect();
					
					
                }
                else
                    this.jLabelStatus.setText("Device not connected");                                
            }
            else
                this.jLabelStatus.setText("Device not connected");                                
        }
        else
            this.jLabelStatus.setText("JSGFPLib Initialization Failed");
		
		
		
		
		//
    }
	
    
    private void disableControls()
    {
		//System.out.print("I am here for testing1fgdfggf");
		//this.jLabelStatus.setText("connection established");
		//String msg = getParameter("Message");
		/*String inputFromPage = this.getParameter("Message");
		this.jLabelStatus.setText(inputFromPage);*/
        //this.jButtonToggleLED.setEnabled(false);
        //this.jButtonCapture.setEnabled(false);
        this.jButtonCaptureR1.setEnabled(false);
        this.jButtonCaptureR2.setEnabled(false);
        //this.jButtonCaptureV1.setEnabled(false);
        this.jButtonRegister.setEnabled(false);
        //this.jButtonVerify.setEnabled(false);
        //this.jButtonGetDeviceInfo.setEnabled(false);
        //this.jButtonConfig.setEnabled(false);
    }
    
    private void enableControls()
    {
		
        this.jButtonToggleLED.setEnabled(true);
        this.jButtonCapture.setEnabled(true);
        this.jButtonCaptureR1.setEnabled(true);
        this.jButtonCaptureR2.setEnabled(true);
        this.jButtonCaptureV1.setEnabled(true);
        this.jButtonGetDeviceInfo.setEnabled(true);
        this.jButtonConfig.setEnabled(true);
		this.jButtonVerify.setEnabled(true);
     }
    private void enableRegisterAndVerifyControls()
    {
        if (r1Captured && r2Captured)
            this.jButtonRegister.setEnabled(true);
        if (r1Captured && r2Captured && v1Captured)
            this.jButtonVerify.setEnabled(true);
    }
    
    /** This method is called from within the constructor to
     * initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is
     * always regenerated by the Form Editor.
     */
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {
		
        jLabelStatus = new javax.swing.JLabel();
        jTabbedPane1 = new javax.swing.JTabbedPane();
        jPanelImage = new javax.swing.JPanel();
        jButtonInit = new javax.swing.JButton();
        jLabelImage = new javax.swing.JLabel();
        jButtonToggleLED = new javax.swing.JButton();
        jButtonCapture = new javax.swing.JButton();
        jButtonConfig = new javax.swing.JButton();
        jLabel1 = new javax.swing.JLabel();
        jComboBoxUSBPort = new javax.swing.JComboBox();
        jLabel2 = new javax.swing.JLabel();
        jSliderQuality = new javax.swing.JSlider();
        jLabel3 = new javax.swing.JLabel();
        jSliderSeconds = new javax.swing.JSlider();
        jPanelRegisterVerify = new javax.swing.JPanel();
        jLabelSecurityLevel = new javax.swing.JLabel();
        jLabelRegistration = new javax.swing.JLabel();
        jLabelVerification = new javax.swing.JLabel();
        jComboBoxRegisterSecurityLevel = new javax.swing.JComboBox();
        jComboBoxVerifySecurityLevel = new javax.swing.JComboBox();
        jLabelRegistrationBox = new javax.swing.JLabel();
        jLabelRegisterImage1 = new javax.swing.JLabel();
        jLabelRegisterImage2 = new javax.swing.JLabel();
        jLabelVerificationBox = new javax.swing.JLabel();
        jLabelVerifyImage = new javax.swing.JLabel();
        jButtonCaptureR1 = new javax.swing.JButton();
        jButtonCaptureV1 = new javax.swing.JButton();
        jButtonRegister = new javax.swing.JButton();
        jButtonVerify = new javax.swing.JButton();
        jButtonCaptureR2 = new javax.swing.JButton();
        jProgressBarR1 = new javax.swing.JProgressBar();
        jProgressBarR2 = new javax.swing.JProgressBar();
        jProgressBarV1 = new javax.swing.JProgressBar();
        jPanelDeviceInfo = new javax.swing.JPanel();
        jLabelDeviceInfoGroup = new javax.swing.JLabel();
        jLabelDeviceID = new javax.swing.JLabel();
        jTextFieldDeviceID = new javax.swing.JTextField();
        jLabelFWVersion = new javax.swing.JLabel();
        jTextFieldFWVersion = new javax.swing.JTextField();
        jLabelSerialNumber = new javax.swing.JLabel();
        jTextFieldSerialNumber = new javax.swing.JTextField();
        jLabelImageWidth = new javax.swing.JLabel();
        jTextFieldImageWidth = new javax.swing.JTextField();
        jLabelImageHeight = new javax.swing.JLabel();
        jTextFieldImageHeight = new javax.swing.JTextField();
        jLabelImageDPI = new javax.swing.JLabel();
        jTextFieldImageDPI = new javax.swing.JTextField();
        jLabelBrightness = new javax.swing.JLabel();
        jTextFieldBrightness = new javax.swing.JTextField();
        jLabelContrast = new javax.swing.JLabel();
        jTextFieldContrast = new javax.swing.JTextField();
        jLabelGain = new javax.swing.JLabel();
        jTextFieldGain = new javax.swing.JTextField();
        jButtonGetDeviceInfo = new javax.swing.JButton();
        jComboBoxDeviceName = new javax.swing.JComboBox();
        jLabelDeviceName = new javax.swing.JLabel();
        jLabelSpacer1 = new javax.swing.JLabel();
        jLabelSpacer2 = new javax.swing.JLabel();
        jButtonClose = new javax.swing.JButton();

        getContentPane().setLayout(new org.netbeans.lib.awtextra.AbsoluteLayout());

        jLabelStatus.setText(" ...");
        jLabelStatus.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));
        getContentPane().add(jLabelStatus, new org.netbeans.lib.awtextra.AbsoluteConstraints(10, 470, 380, 30));

        jPanelImage.setLayout(new org.netbeans.lib.awtextra.AbsoluteLayout());

        jButtonInit.setText("Initialize111");
        jButtonInit.setMaximumSize(new java.awt.Dimension(100, 30));
        jButtonInit.setMinimumSize(new java.awt.Dimension(100, 30));
        jButtonInit.setName("jButtonInit"); // NOI18N
        jButtonInit.setPreferredSize(new java.awt.Dimension(100, 30));
        jButtonInit.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButtonInitActionPerformed(evt);
            }
        });
        jPanelImage.add(jButtonInit, new org.netbeans.lib.awtextra.AbsoluteConstraints(10, 10, 100, 30));

        jLabelImage.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));
        jLabelImage.setMinimumSize(new java.awt.Dimension(260, 300));
        jLabelImage.setPreferredSize(new java.awt.Dimension(260, 300));
        jPanelImage.add(jLabelImage, new org.netbeans.lib.awtextra.AbsoluteConstraints(10, 60, -1, -1));

        jButtonToggleLED.setText("Toggle LED");
        jButtonToggleLED.setMaximumSize(new java.awt.Dimension(100, 30));
        jButtonToggleLED.setMinimumSize(new java.awt.Dimension(100, 30));
        jButtonToggleLED.setPreferredSize(new java.awt.Dimension(100, 30));
        jButtonToggleLED.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButtonToggleLEDActionPerformed(evt);
            }
        });
        //jPanelImage.add(jButtonToggleLED, new org.netbeans.lib.awtextra.AbsoluteConstraints(120, 10, 100, 30));

        jButtonCapture.setText("Capture");
        jButtonCapture.setMaximumSize(new java.awt.Dimension(100, 30));
        jButtonCapture.setMinimumSize(new java.awt.Dimension(100, 30));
        jButtonCapture.setPreferredSize(new java.awt.Dimension(100, 30));
        jButtonCapture.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButtonCaptureActionPerformed(evt);
            }
        });
        //jPanelImage.add(jButtonCapture, new org.netbeans.lib.awtextra.AbsoluteConstraints(230, 10, 100, 30));

        jButtonConfig.setText("Config");
        jButtonConfig.setMaximumSize(new java.awt.Dimension(100, 30));
        jButtonConfig.setMinimumSize(new java.awt.Dimension(100, 30));
        jButtonConfig.setPreferredSize(new java.awt.Dimension(100, 30));
        jButtonConfig.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButtonConfigActionPerformed(evt);
            }
        });
        //jPanelImage.add(jButtonConfig, new org.netbeans.lib.awtextra.AbsoluteConstraints(340, 10, -1, 30));

        jLabel1.setText("USB Device");
        jPanelImage.add(jLabel1, new org.netbeans.lib.awtextra.AbsoluteConstraints(280, 70, -1, -1));

        jComboBoxUSBPort.setModel(new javax.swing.DefaultComboBoxModel(new String[] { "USB_AUTO_DETECT", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9" }));
        jComboBoxUSBPort.setMaximumSize(new java.awt.Dimension(170, 27));
        jComboBoxUSBPort.setMinimumSize(new java.awt.Dimension(170, 27));
        jComboBoxUSBPort.setPreferredSize(new java.awt.Dimension(170, 27));
        jPanelImage.add(jComboBoxUSBPort, new org.netbeans.lib.awtextra.AbsoluteConstraints(280, 90, 170, 27));

        jLabel2.setText("Image Quality");
        jPanelImage.add(jLabel2, new org.netbeans.lib.awtextra.AbsoluteConstraints(280, 150, -1, -1));

        jSliderQuality.setMajorTickSpacing(10);
        jSliderQuality.setMinorTickSpacing(5);
        jSliderQuality.setPaintLabels(true);
        jSliderQuality.setPaintTicks(true);
        jSliderQuality.setName(""); // NOI18N
        jSliderQuality.setOpaque(false);
        jPanelImage.add(jSliderQuality, new org.netbeans.lib.awtextra.AbsoluteConstraints(270, 170, 220, -1));

        jLabel3.setText("Timeout (seconds)");
        jPanelImage.add(jLabel3, new org.netbeans.lib.awtextra.AbsoluteConstraints(290, 230, -1, -1));

        jSliderSeconds.setMajorTickSpacing(1);
        jSliderSeconds.setMaximum(10);
        jSliderSeconds.setMinimum(1);
        jSliderSeconds.setPaintLabels(true);
        jSliderSeconds.setPaintTicks(true);
        jSliderSeconds.setValue(5);
        jPanelImage.add(jSliderSeconds, new org.netbeans.lib.awtextra.AbsoluteConstraints(270, 250, 220, -1));

        //jTabbedPane1.addTab("Image", jPanelImage);

        jPanelRegisterVerify.setLayout(new org.netbeans.lib.awtextra.AbsoluteLayout());
		
		jButtonInit.setText("Initialize");
        jButtonInit.setMaximumSize(new java.awt.Dimension(100, 30));
        jButtonInit.setMinimumSize(new java.awt.Dimension(100, 30));
        jButtonInit.setName("jButtonInit"); // NOI18N
        jButtonInit.setPreferredSize(new java.awt.Dimension(100, 30));
        jButtonInit.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButtonInitActionPerformed(evt);
            }
        });
		
		 jPanelRegisterVerify.add(jButtonInit, new org.netbeans.lib.awtextra.AbsoluteConstraints(10, 10, -1, -1));

        //jLabelSecurityLevel.setBorder(javax.swing.BorderFactory.createTitledBorder("Security Level"));
        //jPanelRegisterVerify.add(jLabelSecurityLevel, new org.netbeans.lib.awtextra.AbsoluteConstraints(10, 10, 460, 60));

        jLabelRegistration.setText("Registration");
        //jPanelRegisterVerify.add(jLabelRegistration, new org.netbeans.lib.awtextra.AbsoluteConstraints(20, 34, -1, -1));

        jLabelVerification.setText("Verification");
       // jPanelRegisterVerify.add(jLabelVerification, new org.netbeans.lib.awtextra.AbsoluteConstraints(250, 34, -1, -1));

        jComboBoxRegisterSecurityLevel.setModel(new javax.swing.DefaultComboBoxModel(new String[] { "LOWEST", "LOWER", "LOW", "BELOW_NORMAL", "NORMAL", "ABOVE_NORMAL", "HIGH", "HIGHER", "HIGHEST" }));
        //jPanelRegisterVerify.add(jComboBoxRegisterSecurityLevel, new org.netbeans.lib.awtextra.AbsoluteConstraints(100, 30, 130, -1));

        jComboBoxVerifySecurityLevel.setModel(new javax.swing.DefaultComboBoxModel(new String[] { "LOWEST", "LOWER", "LOW", "BELOW_NORMAL", "NORMAL", "ABOVE_NORMAL", "HIGH", "HIGHER", "HIGHEST" }));
        //jPanelRegisterVerify.add(jComboBoxVerifySecurityLevel, new org.netbeans.lib.awtextra.AbsoluteConstraints(325, 30, 130, -1));

        jLabelRegistrationBox.setBorder(javax.swing.BorderFactory.createTitledBorder("Registration"));
        jPanelRegisterVerify.add(jLabelRegistrationBox, new org.netbeans.lib.awtextra.AbsoluteConstraints(10, 80, 290, 250));

        jLabelRegisterImage1.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));
        jLabelRegisterImage1.setMinimumSize(new java.awt.Dimension(130, 150));
        jLabelRegisterImage1.setPreferredSize(new java.awt.Dimension(130, 150));
        jPanelRegisterVerify.add(jLabelRegisterImage1, new org.netbeans.lib.awtextra.AbsoluteConstraints(20, 100, -1, -1));

        jLabelRegisterImage2.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));
        jLabelRegisterImage2.setMinimumSize(new java.awt.Dimension(130, 150));
        jLabelRegisterImage2.setPreferredSize(new java.awt.Dimension(130, 150));
        jPanelRegisterVerify.add(jLabelRegisterImage2, new org.netbeans.lib.awtextra.AbsoluteConstraints(160, 100, -1, -1));

        jLabelVerificationBox.setBorder(javax.swing.BorderFactory.createTitledBorder("Verification"));
        jPanelRegisterVerify.add(jLabelVerificationBox, new org.netbeans.lib.awtextra.AbsoluteConstraints(320, 80, 150, 250));

        jLabelVerifyImage.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));
        jLabelVerifyImage.setMinimumSize(new java.awt.Dimension(130, 150));
        jLabelVerifyImage.setPreferredSize(new java.awt.Dimension(130, 150));
        jPanelRegisterVerify.add(jLabelVerifyImage, new org.netbeans.lib.awtextra.AbsoluteConstraints(330, 100, -1, -1));

        jButtonCaptureR1.setText("Capture R1");
        jButtonCaptureR1.setActionCommand("jButton1");
        jButtonCaptureR1.setMaximumSize(new java.awt.Dimension(130, 30));
        jButtonCaptureR1.setMinimumSize(new java.awt.Dimension(130, 30));
        jButtonCaptureR1.setPreferredSize(new java.awt.Dimension(130, 30));
        jButtonCaptureR1.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButtonCaptureR1ActionPerformed(evt);
            }
        });
		
		
        jPanelRegisterVerify.add(jButtonCaptureR1, new org.netbeans.lib.awtextra.AbsoluteConstraints(20, 280, 130, 30));

        jButtonCaptureV1.setText("Capture V1");
        jButtonCaptureV1.setActionCommand("jButton1");
        jButtonCaptureV1.setMaximumSize(new java.awt.Dimension(130, 30));
        jButtonCaptureV1.setMinimumSize(new java.awt.Dimension(130, 30));
        jButtonCaptureV1.setPreferredSize(new java.awt.Dimension(130, 30));
        jButtonCaptureV1.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButtonCaptureV1ActionPerformed(evt);
            }
        });
        jPanelRegisterVerify.add(jButtonCaptureV1, new org.netbeans.lib.awtextra.AbsoluteConstraints(330, 280, 130, 30));

        jButtonRegister.setText("Register");
        jButtonRegister.setActionCommand("jButton1");
        jButtonRegister.setMaximumSize(new java.awt.Dimension(270, 30));
        jButtonRegister.setMinimumSize(new java.awt.Dimension(270, 30));
        jButtonRegister.setPreferredSize(new java.awt.Dimension(270, 30));
        jButtonRegister.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButtonRegisterActionPerformed(evt);
            }
        });
        jPanelRegisterVerify.add(jButtonRegister, new org.netbeans.lib.awtextra.AbsoluteConstraints(20, 340, 270, 30));

        jButtonVerify.setText("Verify");
        jButtonVerify.setActionCommand("jButton1");
        jButtonVerify.setMaximumSize(new java.awt.Dimension(130, 30));
        jButtonVerify.setMinimumSize(new java.awt.Dimension(130, 30));
        jButtonVerify.setPreferredSize(new java.awt.Dimension(130, 30));
        jButtonVerify.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButtonVerifyActionPerformed(evt);
            }
        });
        //jPanelRegisterVerify.add(jButtonVerify, new org.netbeans.lib.awtextra.AbsoluteConstraints(330, 340, 130, 30));

        jButtonCaptureR2.setText("Capture R2");
        jButtonCaptureR2.setActionCommand("jButton1");
        jButtonCaptureR2.setMaximumSize(new java.awt.Dimension(130, 30));
        jButtonCaptureR2.setMinimumSize(new java.awt.Dimension(130, 30));
        jButtonCaptureR2.setPreferredSize(new java.awt.Dimension(130, 30));
        jButtonCaptureR2.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButtonCaptureR2ActionPerformed(evt);
            }
        });
        jPanelRegisterVerify.add(jButtonCaptureR2, new org.netbeans.lib.awtextra.AbsoluteConstraints(160, 280, 130, 30));

        jProgressBarR1.setForeground(new java.awt.Color(0, 51, 153));
        jPanelRegisterVerify.add(jProgressBarR1, new org.netbeans.lib.awtextra.AbsoluteConstraints(20, 250, 130, -1));

        jProgressBarR2.setForeground(new java.awt.Color(0, 51, 153));
        jPanelRegisterVerify.add(jProgressBarR2, new org.netbeans.lib.awtextra.AbsoluteConstraints(160, 250, 130, -1));

        jProgressBarV1.setForeground(new java.awt.Color(0, 51, 153));
        jPanelRegisterVerify.add(jProgressBarV1, new org.netbeans.lib.awtextra.AbsoluteConstraints(330, 250, 130, -1));

        jTabbedPane1.addTab("Register/Verify", jPanelRegisterVerify);

        jPanelDeviceInfo.setLayout(new org.netbeans.lib.awtextra.AbsoluteLayout());

        jLabelDeviceInfoGroup.setBorder(javax.swing.BorderFactory.createTitledBorder("DeviceInfo"));
        jPanelDeviceInfo.add(jLabelDeviceInfoGroup, new org.netbeans.lib.awtextra.AbsoluteConstraints(10, 10, 290, 290));

        jLabelDeviceID.setText("Device ID");
        jPanelDeviceInfo.add(jLabelDeviceID, new org.netbeans.lib.awtextra.AbsoluteConstraints(30, 30, -1, -1));

        jTextFieldDeviceID.setEditable(false);
        jTextFieldDeviceID.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));
        jPanelDeviceInfo.add(jTextFieldDeviceID, new org.netbeans.lib.awtextra.AbsoluteConstraints(120, 30, 160, -1));

        jLabelFWVersion.setText("F/W Version");
        jPanelDeviceInfo.add(jLabelFWVersion, new org.netbeans.lib.awtextra.AbsoluteConstraints(30, 60, -1, -1));

        jTextFieldFWVersion.setEditable(false);
        jTextFieldFWVersion.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));
        jPanelDeviceInfo.add(jTextFieldFWVersion, new org.netbeans.lib.awtextra.AbsoluteConstraints(120, 60, 160, -1));

        jLabelSerialNumber.setText("Serial #");
        jPanelDeviceInfo.add(jLabelSerialNumber, new org.netbeans.lib.awtextra.AbsoluteConstraints(30, 90, -1, -1));

        jTextFieldSerialNumber.setEditable(false);
        jTextFieldSerialNumber.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));
        jPanelDeviceInfo.add(jTextFieldSerialNumber, new org.netbeans.lib.awtextra.AbsoluteConstraints(120, 90, 160, -1));

        jLabelImageWidth.setText("Image Width");
        jPanelDeviceInfo.add(jLabelImageWidth, new org.netbeans.lib.awtextra.AbsoluteConstraints(30, 120, -1, -1));

        jTextFieldImageWidth.setEditable(false);
        jTextFieldImageWidth.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));
        jPanelDeviceInfo.add(jTextFieldImageWidth, new org.netbeans.lib.awtextra.AbsoluteConstraints(120, 120, 160, -1));

        jLabelImageHeight.setText("Image Height");
        jPanelDeviceInfo.add(jLabelImageHeight, new org.netbeans.lib.awtextra.AbsoluteConstraints(30, 150, -1, -1));

        jTextFieldImageHeight.setEditable(false);
        jTextFieldImageHeight.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));
        jPanelDeviceInfo.add(jTextFieldImageHeight, new org.netbeans.lib.awtextra.AbsoluteConstraints(120, 150, 160, -1));

        jLabelImageDPI.setText("Image DPI");
        jPanelDeviceInfo.add(jLabelImageDPI, new org.netbeans.lib.awtextra.AbsoluteConstraints(30, 180, -1, -1));

        jTextFieldImageDPI.setEditable(false);
        jTextFieldImageDPI.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));
        jPanelDeviceInfo.add(jTextFieldImageDPI, new org.netbeans.lib.awtextra.AbsoluteConstraints(120, 180, 160, -1));

        jLabelBrightness.setText("Brightness");
        jPanelDeviceInfo.add(jLabelBrightness, new org.netbeans.lib.awtextra.AbsoluteConstraints(30, 210, -1, -1));

        jTextFieldBrightness.setEditable(false);
        jTextFieldBrightness.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));
        jPanelDeviceInfo.add(jTextFieldBrightness, new org.netbeans.lib.awtextra.AbsoluteConstraints(120, 210, 160, -1));

        jLabelContrast.setText("Contrast");
        jPanelDeviceInfo.add(jLabelContrast, new org.netbeans.lib.awtextra.AbsoluteConstraints(30, 240, -1, -1));

        jTextFieldContrast.setEditable(false);
        jTextFieldContrast.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));
        jPanelDeviceInfo.add(jTextFieldContrast, new org.netbeans.lib.awtextra.AbsoluteConstraints(120, 240, 160, -1));

        jLabelGain.setText("Gain");
        jPanelDeviceInfo.add(jLabelGain, new org.netbeans.lib.awtextra.AbsoluteConstraints(30, 270, -1, -1));

        jTextFieldGain.setEditable(false);
        jTextFieldGain.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.LOWERED));
        jPanelDeviceInfo.add(jTextFieldGain, new org.netbeans.lib.awtextra.AbsoluteConstraints(120, 270, 160, -1));

        jButtonGetDeviceInfo.setText("Get Device Info");
        jButtonGetDeviceInfo.setMaximumSize(new java.awt.Dimension(150, 30));
        jButtonGetDeviceInfo.setMinimumSize(new java.awt.Dimension(150, 30));
        jButtonGetDeviceInfo.setPreferredSize(new java.awt.Dimension(150, 30));
        jButtonGetDeviceInfo.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButtonGetDeviceInfoActionPerformed(evt);
            }
        });
        jPanelDeviceInfo.add(jButtonGetDeviceInfo, new org.netbeans.lib.awtextra.AbsoluteConstraints(320, 20, 150, 30));

        //jTabbedPane1.addTab("Device Info", jPanelDeviceInfo);

        getContentPane().add(jTabbedPane1, new org.netbeans.lib.awtextra.AbsoluteConstraints(10, 35, 500, 420));

        jComboBoxDeviceName.setModel(new javax.swing.DefaultComboBoxModel(new String[] {"FDU03"}));
        jComboBoxDeviceName.setMinimumSize(new java.awt.Dimension(350, 10));
        jComboBoxDeviceName.setVerifyInputWhenFocusTarget(false);
        getContentPane().add(jComboBoxDeviceName, new org.netbeans.lib.awtextra.AbsoluteConstraints(130, 10, 350, -1));

        jLabelDeviceName.setText("Device Name");
        getContentPane().add(jLabelDeviceName, new org.netbeans.lib.awtextra.AbsoluteConstraints(10, 11, 110, -1));

        jLabelSpacer1.setText(" ");
        getContentPane().add(jLabelSpacer1, new org.netbeans.lib.awtextra.AbsoluteConstraints(510, 490, 10, -1));

        jLabelSpacer2.setText(" ");
        getContentPane().add(jLabelSpacer2, new org.netbeans.lib.awtextra.AbsoluteConstraints(510, 10, 10, -1));

        jButtonClose.setText("Close");
        jButtonClose.setMaximumSize(new java.awt.Dimension(90, 30));
        jButtonClose.setMinimumSize(new java.awt.Dimension(90, 30));
        jButtonClose.setPreferredSize(new java.awt.Dimension(90, 30));
        jButtonClose.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jButtonCloseActionPerformed(evt);
            }
        });
		
		
        //getContentPane().add(jButtonClose, new org.netbeans.lib.awtextra.AbsoluteConstraints(410, 470, -1, -1));
    }// </editor-fold>//GEN-END:initComponents

    private void jButtonCloseActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButtonCloseActionPerformed
        long iError;

        iError = fplib.Close();
         if (iError == SGFDxErrorCode.SGFDX_ERROR_NONE)
         {
            this.jLabelStatus.setText( "Close() Success");
            this.disableControls();
            this.jTabbedPane1.setSelectedIndex(0);
         }
         else
            this.jLabelStatus.setText( "Close() Error : " + iError);
		
		
		
        
    }//GEN-LAST:event_jButtonCloseActionPerformed

    private void jButtonGetDeviceInfoActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButtonGetDeviceInfoActionPerformed
        long iError;

        iError = fplib.GetDeviceInfo(deviceInfo);
        if (ret == SGFDxErrorCode.SGFDX_ERROR_NONE)
        {
            this.jLabelStatus.setText( "Device Ready");
            this.jTextFieldSerialNumber.setText(new String(deviceInfo.deviceSN()));
            this.jTextFieldBrightness.setText(new String(Integer.toString(deviceInfo.brightness)));
            this.jTextFieldContrast.setText(new String(Integer.toString((int)deviceInfo.contrast)));
            this.jTextFieldDeviceID.setText(new String(Integer.toString(deviceInfo.deviceID)));
            this.jTextFieldFWVersion.setText(new String(Integer.toHexString(deviceInfo.FWVersion)));
            this.jTextFieldGain.setText(new String(Integer.toString(deviceInfo.gain)));
            this.jTextFieldImageDPI.setText(new String(Integer.toString(deviceInfo.imageDPI)));
            this.jTextFieldImageHeight.setText(new String(Integer.toString(deviceInfo.imageHeight)));
            this.jTextFieldImageWidth.setText(new String(Integer.toString(deviceInfo.imageWidth)));
        }
         else
            this.jLabelStatus.setText( "GetDeviceInfo() Error : " + iError);
         
    }//GEN-LAST:event_jButtonGetDeviceInfoActionPerformed

    private void jButtonConfigActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButtonConfigActionPerformed
        long iError;

        iError = fplib.Configure(0);
         if (iError == SGFDxErrorCode.SGFDX_ERROR_NONE)
         {
            this.jLabelStatus.setText( "Configure() Success");
           this.jButtonGetDeviceInfo.doClick();
         }
         else if (iError == SGFDxErrorCode.SGFDX_ERROR_NONE)
            this.jLabelStatus.setText( "Configure() not supported on this platform");
         else
            this.jLabelStatus.setText( "Configure() Error : " + iError);
        
        
    }//GEN-LAST:event_jButtonConfigActionPerformed

    private void jButtonVerifyActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButtonVerifyActionPerformed
         long iError;
         long secuLevel = (long) (this.jComboBoxVerifySecurityLevel.getSelectedIndex() + 1);
		// long secuLevel=SGFDxSecurityLevel.SL_NORMAL
         boolean[] matched = new boolean[1];
         matched[0] = false;
		String patientname = null;
		String location_id = null;
		String userfullname = null;
		String loginDate = null;
		String currentTimevalue=null;
		String inouttimeval= null;
		String isUserexist=null;
		String intime=null;
		String outtime=null;
		String userLocationid=null;
		String ispresent=null;
		String ispre_value=null;
		String role_id=null;
		URL userUrl;
		String outimeallow=null;
		String previousouttime=null;
		String previousId="0";
		String previoussamedayId="0";
		String usershift=null;
		String usershiftTime=null;
		String mispunch="0";
		String shiftalreadyapplied="0";
		String previousouttimeval="0";
		
		 
		 
		 //pankaj code
		 try{	                 
				URL staffUrl = getDocumentBase();
			    userLocationid=staffUrl.getQuery();					   
					 
                		if(conn != null){	
							 stmt = conn.createStatement();
                             ResultSet rs = stmt.executeQuery("select regmin1 as regmin1,regmin2 as regmin2,first_name as fname,last_name as lname, id as userid,location_id as location_id,role_id as role_id from users where regmin1 IS NOT NULL and regmin2 IS NOT NULL and location_id='"+userLocationid+"'");
                            
							 while(rs.next()){
								String regMinM1= rs.getString("regmin1");//(68)
								String regMinM2 = rs.getString("regmin2");//(69)
								regMin1=DatatypeConverter.parseBase64Binary(regMinM1);
								regMin2=DatatypeConverter.parseBase64Binary(regMinM2);
								
								iError = fplib.MatchTemplate(regMin1, vrfMin, secuLevel, matched);
		
         if (iError == SGFDxErrorCode.SGFDX_ERROR_NONE)
         {
             if (matched[0])
			 {
				
                this.jLabelStatus.setText( "Verification Success - "+rs.getString("fname")+" "+rs.getString("lname"));
				location_id=rs.getString("location_id");
				role_id=rs.getString("role_id");
						//userfullname=rs.getString(8);
						patientname=rs.getString("userid");
						 SimpleDateFormat sdfDate = new SimpleDateFormat("yyyy-MM-dd");//dd/MM/yyyy
                          Date now = new Date();
                         String strDate = sdfDate.format(now);
						 
						 SimpleDateFormat sdf = new SimpleDateFormat("HH:mm:ss");
						 Calendar cal = Calendar.getInstance();
    	                 String currentTime= sdf.format(cal.getTime());
						 String outTime= sdf.format(cal.getTime());
						ResultSet rsinouttime = stmt.executeQuery("select inouttime as inouttime,is_present as is_present,intime as intime,outime as outime from duty_rosters where user_id='"+patientname+"' and date='"+strDate+"' and location_id='"+userLocationid+"'");
						
						
						if(rsinouttime.next()) {
                         inouttimeval = rsinouttime.getString("inouttime");
						 ispresent = rsinouttime.getString("is_present");
						 intime = rsinouttime.getString("intime");
						 isUserexist="1";
						
						 }
						 else
						 { 
						     isUserexist="0";
						 }
						 
						 //find shift of the user
						ResultSet rssql_shift = stmt.executeQuery("select shifts from placement_histories where user_id='"+patientname+"'");
						if(rssql_shift.next()) {
                           usershift = rssql_shift.getString("shifts");
						   //find shift timing
						   ResultSet rssql_shiftTime = stmt.executeQuery("select from_time from shifts where id='"+usershift+"'");
						   if(rssql_shiftTime.next()) {
							   usershiftTime = rssql_shiftTime.getString("from_time")+":00"; 
							   DateFormat usershifttimeValue = new SimpleDateFormat("HH:mm:ss");
                               Date usershifttimeValuefinal = usershifttimeValue.parse(usershiftTime);
							   Date shifttime1 = usershifttimeValue.parse(usershiftTime);
                               Date curtime = usershifttimeValue.parse(currentTime);
							   long differencet = curtime.getTime() - shifttime1.getTime();
                               long diffSecondst = differencet/1000;
							   System.out.println(diffSecondst);
							   if(diffSecondst>3600)
								   mispunch="1";
							   
						   }
						}
						 
						 if(isUserexist== "1")
						 {
							 SimpleDateFormat format = new SimpleDateFormat("HH:mm:ss");
                             Date date1 = format.parse(intime);
                             Date date2 = format.parse(currentTime);
                             long difference = date2.getTime() - date1.getTime();
                             long diffSeconds = difference/1000;
							 
                             if(diffSeconds>600)
								 outimeallow="1";
							 
						   currentTime= inouttimeval+"::"+currentTime;
						 }
						    						   
                        if(isUserexist=="1")
						{							
							String is_present = new String(ispresent);
							String Str2 = "Y";
							if(is_present.equals(Str2))
							{
								
								ispre_value="N";
							}
							else
							{
								
								ispre_value="Y";
							}
							
							if(outimeallow=="1")
							{
						           String sql_user = "UPDATE duty_rosters " +
                                   "SET inouttime='"+currentTime+"',is_present='"+ispre_value+"',outime='"+outTime+"' WHERE user_id = '"+patientname+"' and date='"+strDate+"'";
								   stmt.executeUpdate(sql_user);
							}
						}
						 else
						 {
							 //find outime of the user 
							 
							 ResultSet rsouttime = stmt.executeQuery("select id as id from duty_rosters where user_id='"+patientname+"' and date='"+strDate+"' and outime IS NULL order by id desc limit 0,1");
							 if(rsouttime.next()) {
						    	  previousId = rsouttime.getString("id");
							 }
							 
							
							 if(previousId=="0")
							 {
								 
								 String created_by = this.getParameter("created_by");
								//select query last record for the user if its outime is still null. Current date condition is skipped here and outime is null
					            ResultSet rslastoutime = stmt.executeQuery("select id as id,outime as outime from duty_rosters where user_id='"+patientname+"' order by id desc limit 0,1");
								
								if(rslastoutime.next()) {
						    	  previoussamedayId = rslastoutime.getString("id");
								  previousouttimeval = rslastoutime.getString("outime");
							     }
								 System.out.println(previoussamedayId);
								 System.out.println(previousouttimeval);
								if(previoussamedayId=="0")
								{
									//check if user shift is applied on the the particular day for that location. In this case duty roster will be updated with intime
									ResultSet rsshiftalreadyapplied = stmt.executeQuery("select id as id from duty_rosters where user_id='"+patientname+"' and date='"+strDate+"' and shift IS NOT NULL");
									if(rsshiftalreadyapplied.next()) {
						    	       shiftalreadyapplied = rsshiftalreadyapplied.getString("id");
							        }
									
									if(shiftalreadyapplied=="0")
									{									
						               String sql_user = "INSERT INTO duty_rosters (location_id,user_id,date,inouttime,is_present,role_id,intime,created_by,shift,missed_punch) " + "VALUES ('"+userLocationid+"','"+patientname+"','"+strDate+"','"+currentTime+"','Y','"+role_id+"','"+currentTime+"','"+created_by+"','"+usershift+"','"+mispunch+"')";
							            stmt.executeUpdate(sql_user);
									}
									else
									{
										/*String sql_user = "INSERT INTO duty_rosters (location_id,user_id,date,inouttime,is_present,role_id,intime,created_by,shift,missed_punch) " + "VALUES ('"+userLocationid+"','"+patientname+"','"+strDate+"','"+currentTime+"','Y','"+role_id+"','"+currentTime+"','"+created_by+"','"+usershift+"','"+mispunch+"')";
							         stmt.executeUpdate(sql_user);*/
										String sql_updateshift = "UPDATE duty_rosters " +
                                        "SET intime='"+currentTime+"',is_present='Y',role_id='"+role_id+"',created_by='"+created_by+"' WHERE id='"+shiftalreadyapplied+"'";
								 	    stmt.executeUpdate(sql_updateshift);
									}
								}
								else
								{
									
									//check if user shift is applied on the the particular day for that location. In this case duty roster will be updated with intime
									ResultSet rsshiftalreadyapplied = stmt.executeQuery("select id as id from duty_rosters where user_id='"+patientname+"' and date='"+strDate+"' and shift IS NOT NULL");
									if(rsshiftalreadyapplied.next()) {
						    	       shiftalreadyapplied = rsshiftalreadyapplied.getString("id");
							        }
									
									if(shiftalreadyapplied=="0")
									{
										if(previousouttimeval == null)
										{
						                     /* NOT required for HOPE
											 String sql_updateprevioussameday = "UPDATE duty_rosters " +
                                             "SET outime='"+currentTime+"',is_present='N' WHERE id='"+previoussamedayId+"' and outime IS NULL";
								 	         stmt.executeUpdate(sql_updateprevioussameday); */
											 
											 String sql_user = "INSERT INTO duty_rosters (location_id,user_id,date,inouttime,is_present,role_id,intime,created_by,shift,missed_punch) " + "VALUES ('"+userLocationid+"','"+patientname+"','"+strDate+"','"+currentTime+"','Y','"+role_id+"','"+currentTime+"','"+created_by+"','"+usershift+"','"+mispunch+"')";
							               stmt.executeUpdate(sql_user);
										}
										else
										{
											String sql_user = "INSERT INTO duty_rosters (location_id,user_id,date,inouttime,is_present,role_id,intime,created_by,shift,missed_punch) " + "VALUES ('"+userLocationid+"','"+patientname+"','"+strDate+"','"+currentTime+"','Y','"+role_id+"','"+currentTime+"','"+created_by+"','"+usershift+"','"+mispunch+"')";
							               stmt.executeUpdate(sql_user);
											
										}
									}
									else
									{
										/*String sql_user = "INSERT INTO duty_rosters (location_id,user_id,date,inouttime,is_present,role_id,intime,created_by,shift,missed_punch) " + "VALUES ('"+userLocationid+"','"+patientname+"','"+strDate+"','"+currentTime+"','Y','"+role_id+"','"+currentTime+"','"+created_by+"','"+usershift+"','"+mispunch+"')";
							         stmt.executeUpdate(sql_user);*/
										String sql_updateshift = "UPDATE duty_rosters " +
                                        "SET intime='"+currentTime+"',is_present='Y',role_id='"+role_id+"',created_by='"+created_by+"' WHERE id='"+shiftalreadyapplied+"'";
								 	    stmt.executeUpdate(sql_updateshift);
									}
									
									/*String sql_user = "INSERT INTO duty_rosters (location_id,user_id,date,inouttime,is_present,role_id,intime,created_by,shift,missed_punch) " + "VALUES ('"+userLocationid+"','"+patientname+"','"+strDate+"','"+currentTime+"','Y','"+role_id+"','"+currentTime+"','"+created_by+"','"+usershift+"','"+mispunch+"')";
							         stmt.executeUpdate(sql_user);
									/*String sql_updateprevioussameday = "UPDATE duty_rosters " +
                                   "SET outime='"+currentTime+"',is_present='N' WHERE id='"+previoussamedayId+"' and outime IS NULL";
								 	stmt.executeUpdate(sql_updateprevioussameday);*/
								}
							 }
							 else
							 {
								
								 String created_by = this.getParameter("created_by");
								 
								 String sql_update = "UPDATE duty_rosters " +
                                   "SET outime='"+currentTime+"',is_present='N' WHERE id='"+previousId+"' and outime IS NULL";
								 	stmt.executeUpdate(sql_update);
								
								 
								 //check if user shift is applied on the the particular day for that location. In this case duty roster will be updated with intime
									ResultSet rsshiftalreadyapplied = stmt.executeQuery("select id as id from duty_rosters where user_id='"+patientname+"' and date='"+strDate+"' and shift IS NOT NULL");
									if(rsshiftalreadyapplied.next()) {
						    	       shiftalreadyapplied = rsshiftalreadyapplied.getString("id");
							        }
									
									if(shiftalreadyapplied=="0")
									{									
						               String sql_user = "INSERT INTO duty_rosters (location_id,user_id,date,inouttime,is_present,role_id,intime,created_by,shift,missed_punch) " + "VALUES ('"+userLocationid+"','"+patientname+"','"+strDate+"','"+currentTime+"','Y','"+role_id+"','"+currentTime+"','"+created_by+"','"+usershift+"','"+mispunch+"')";
								      stmt.executeUpdate(sql_user); 
									}
									else
									{
										/*String sql_user = "INSERT INTO duty_rosters (location_id,user_id,date,inouttime,is_present,role_id,intime,created_by,shift,missed_punch) " + "VALUES ('"+userLocationid+"','"+patientname+"','"+strDate+"','"+currentTime+"','Y','"+role_id+"','"+currentTime+"','"+created_by+"','"+usershift+"','"+mispunch+"')";
								      stmt.executeUpdate(sql_user);*/ 
										String sql_updateshift = "UPDATE duty_rosters " +
                                        "SET intime='"+currentTime+"',is_present='Y',role_id='"+role_id+"',created_by='"+created_by+"' WHERE id='"+shiftalreadyapplied+"'";
								 	    stmt.executeUpdate(sql_updateshift);
									}
								 
							
							    
							 }
						}
							 
						
				break;
				}
             else
             {
                 iError = fplib.MatchTemplate(regMin2, vrfMin, secuLevel, matched);
                 if (iError == SGFDxErrorCode.SGFDX_ERROR_NONE)
                     if (matched[0])
					 {
                        this.jLabelStatus.setText( "Verification Success - "+rs.getString("fname")+" "+rs.getString("lname"));
				location_id=rs.getString("location_id");
				role_id=rs.getString("role_id");
						//userfullname=rs.getString(8);
						patientname=rs.getString("userid");
						 SimpleDateFormat sdfDate = new SimpleDateFormat("yyyy-MM-dd");//dd/MM/yyyy
                          Date now = new Date();
                         String strDate = sdfDate.format(now);
						 
						 SimpleDateFormat sdf = new SimpleDateFormat("HH:mm:ss");
						 Calendar cal = Calendar.getInstance();
    	                 String currentTime= sdf.format(cal.getTime());
						 String outTime= sdf.format(cal.getTime());
						 
						 ResultSet rsinouttime = stmt.executeQuery("select inouttime as inouttime,is_present as is_present,intime as intime,outime as outime from duty_rosters where user_id='"+patientname+"' and date='"+strDate+"'");
					
						  if(rsinouttime.next()) {
                         inouttimeval = rsinouttime.getString("inouttime");
						 ispresent = rsinouttime.getString("is_present");
						 intime = rsinouttime.getString("intime");
						 isUserexist="1";
						
						 }
						 else
						     isUserexist="0";
						 
						 //find shift of the user
						ResultSet rssql_shift = stmt.executeQuery("select shifts from placement_histories where user_id='"+patientname+"'");
						if(rssql_shift.next()) {
                           usershift = rssql_shift.getString("shifts");
						   //find shift timing
						   ResultSet rssql_shiftTime = stmt.executeQuery("select from_time from shifts where id='"+usershift+"'");
						  
						  if(rssql_shiftTime.next()) {
							   usershiftTime = rssql_shiftTime.getString("from_time")+":00"; 
							   DateFormat usershifttimeValue = new SimpleDateFormat("HH:mm:ss");
                               Date usershifttimeValuefinal = usershifttimeValue.parse(usershiftTime);
							   Date shifttime1 = usershifttimeValue.parse(usershiftTime);
                               Date curtime = usershifttimeValue.parse(currentTime);
							   long differencet = curtime.getTime() - shifttime1.getTime();
                               long diffSecondst = differencet/1000;
							   System.out.println(diffSecondst);
							   if(diffSecondst>3600)
								   mispunch="1";
							   
						   }
						}
						  
						  
						  
						 if(isUserexist== "1")
						 {
							SimpleDateFormat format = new SimpleDateFormat("HH:mm:ss");
                             Date date1 = format.parse(intime);
                             Date date2 = format.parse(currentTime);
                             long difference = date2.getTime() - date1.getTime();
                             long diffSeconds = difference/1000;
							 
                             if(diffSeconds>600)
								 outimeallow="1";						 
							 
						   currentTime= inouttimeval+"::"+currentTime;
						 }
						 
						   
                        if(isUserexist=="1")
						{
							
							String is_present = new String(ispresent);
							String Str2 = "Y";
							if(is_present.equals(Str2))
							{
								ispre_value="N";
								
							}
							else
							{
								ispre_value="Y";
								
							}
							if(outimeallow=="1")
							{
						           String sql_user = "UPDATE duty_rosters " +
                                   "SET inouttime='"+currentTime+"',is_present='"+ispre_value+"',outime='"+outTime+"' WHERE user_id = '"+patientname+"' and date='"+strDate+"' ";
								   	stmt.executeUpdate(sql_user);
							}
								  
						}
						 else
						 {
							 
							 ResultSet rsouttime = stmt.executeQuery("select id as id from duty_rosters where user_id='"+patientname+"' and date='"+strDate+"' and outime IS NULL order by id desc limit 0,1");
							 if(rsouttime.next()) {
								previousId = rsouttime.getString("id");
							 }
							
							 if(previousId=="0")
							 {
								 String created_by = this.getParameter("created_by");
								 
								 //select query last record for the user if its outime is still null. Current date condition is skipped here
					            ResultSet rslastoutime = stmt.executeQuery("select id as id,outime as outime from duty_rosters where user_id='"+patientname+"' order by id desc limit 0,1");
								
								if(rslastoutime.next()) {
						    	  previoussamedayId = rslastoutime.getString("id");
								  previousouttimeval = rslastoutime.getString("outime");
							     }
								if(previoussamedayId=="0")
								{ 
							
							 //check if user shift is applied on the the particular day for that location. In this case duty roster will be updated with intime
									ResultSet rsshiftalreadyapplied = stmt.executeQuery("select id as id from duty_rosters where user_id='"+patientname+"' and date='"+strDate+"' and shift IS NOT NULL");
									if(rsshiftalreadyapplied.next()) {
						    	       shiftalreadyapplied = rsshiftalreadyapplied.getString("id");
							        }
									
									if(shiftalreadyapplied=="0")
									{									
						               String sql_user = "INSERT INTO duty_rosters (location_id,user_id,date,inouttime,is_present,role_id,intime,created_by,shift,missed_punch) " + "VALUES ('"+userLocationid+"','"+patientname+"','"+strDate+"','"+currentTime+"','Y','"+role_id+"','"+currentTime+"','"+created_by+"','"+usershift+"','"+mispunch+"')";
							           stmt.executeUpdate(sql_user);
									}
									else
									{
										/*String sql_user = "INSERT INTO duty_rosters (location_id,user_id,date,inouttime,is_present,role_id,intime,created_by,shift,missed_punch) " + "VALUES ('"+userLocationid+"','"+patientname+"','"+strDate+"','"+currentTime+"','Y','"+role_id+"','"+currentTime+"','"+created_by+"','"+usershift+"','"+mispunch+"')";
										stmt.executeUpdate(sql_user);*/
										String sql_updateshift = "UPDATE duty_rosters " +
                                        "SET intime='"+currentTime+"',is_present='Y',role_id='"+role_id+"',created_by='"+created_by+"' WHERE id='"+shiftalreadyapplied+"'";
								 	    stmt.executeUpdate(sql_updateshift);
									}
						             
								}
								else
								{
									
									//check if user shift is applied on the the particular day for that location. In this case duty roster will be updated with intime
									ResultSet rsshiftalreadyapplied = stmt.executeQuery("select id as id from duty_rosters where user_id='"+patientname+"' and date='"+strDate+"' and shift IS NOT NULL");
									if(rsshiftalreadyapplied.next()) {
						    	       shiftalreadyapplied = rsshiftalreadyapplied.getString("id");
							        }
									
									if(shiftalreadyapplied=="0")
									{	
								       if(previousouttimeval == null)
										{										
						                  String sql_user = "INSERT INTO duty_rosters (location_id,user_id,date,inouttime,is_present,role_id,intime,created_by,shift,missed_punch) " + "VALUES ('"+userLocationid+"','"+patientname+"','"+strDate+"','"+currentTime+"','Y','"+role_id+"','"+currentTime+"','"+created_by+"','"+usershift+"','"+mispunch+"')";
							              stmt.executeUpdate(sql_user);
									   }
									   else
									   {
										   /*
										   String sql_updateprevioussameday = "UPDATE duty_rosters " +
                                           "SET outime='"+currentTime+"',is_present='N' WHERE id='"+previoussamedayId+"' and outime IS NULL";
								 	       stmt.executeUpdate(sql_updateprevioussameday);
										   */
										   
										   String sql_user = "INSERT INTO duty_rosters (location_id,user_id,date,inouttime,is_present,role_id,intime,created_by,shift,missed_punch) " + "VALUES ('"+userLocationid+"','"+patientname+"','"+strDate+"','"+currentTime+"','Y','"+role_id+"','"+currentTime+"','"+created_by+"','"+usershift+"','"+mispunch+"')";
							              stmt.executeUpdate(sql_user);
										   
									   }
									}
									else
									{
										/*String sql_user = "INSERT INTO duty_rosters (location_id,user_id,date,inouttime,is_present,role_id,intime,created_by,shift,missed_punch) " + "VALUES ('"+userLocationid+"','"+patientname+"','"+strDate+"','"+currentTime+"','Y','"+role_id+"','"+currentTime+"','"+created_by+"','"+usershift+"','"+mispunch+"')";
										stmt.executeUpdate(sql_user);*/
										String sql_updateshift = "UPDATE duty_rosters " +
                                        "SET intime='"+currentTime+"',is_present='Y',role_id='"+role_id+"',created_by='"+created_by+"' WHERE id='"+shiftalreadyapplied+"'";
								 	    stmt.executeUpdate(sql_updateshift);
									}
									
									/*String sql_user = "INSERT INTO duty_rosters (location_id,user_id,date,inouttime,is_present,role_id,intime,created_by,shift,missed_punch) " + "VALUES ('"+userLocationid+"','"+patientname+"','"+strDate+"','"+currentTime+"','Y','"+role_id+"','"+currentTime+"','"+created_by+"','"+usershift+"','"+mispunch+"')";
										stmt.executeUpdate(sql_user);
									/*String sql_updateprevioussameday = "UPDATE duty_rosters " +
                                   "SET outime='"+currentTime+"',is_present='N' WHERE id='"+previoussamedayId+"' and outime IS NULL";
								 	stmt.executeUpdate(sql_updateprevioussameday);*/
								}
									
							 }
							 else
							 {
								  String created_by = this.getParameter("created_by");
								  String sql_update = "UPDATE duty_rosters " +
                                   "SET outime='"+currentTime+"',is_present='N' WHERE id='"+previousId+"' and outime IS NULL";
								 stmt.executeUpdate(sql_update);
								
								 //check if user shift is applied on the the particular day for that location. In this case duty roster will be updated with intime
									ResultSet rsshiftalreadyapplied = stmt.executeQuery("select id as id from duty_rosters where user_id='"+patientname+"' and date='"+strDate+"' and shift IS NOT NULL");
									if(rsshiftalreadyapplied.next()) {
						    	       shiftalreadyapplied = rsshiftalreadyapplied.getString("id");
							        }
									
									if(shiftalreadyapplied=="0")
									{									
						               String sql_user = "INSERT INTO duty_rosters (location_id,user_id,date,inouttime,is_present,role_id,intime,created_by,shift,missed_punch) " + "VALUES ('"+userLocationid+"','"+patientname+"','"+strDate+"','"+currentTime+"','Y','"+role_id+"','"+currentTime+"','"+created_by+"','"+usershift+"','"+mispunch+"')";
								stmt.executeUpdate(sql_user); 
									}
									else
									{
										/*String sql_user = "INSERT INTO duty_rosters (location_id,user_id,date,inouttime,is_present,role_id,intime,created_by,shift,missed_punch) " + "VALUES ('"+userLocationid+"','"+patientname+"','"+strDate+"','"+currentTime+"','Y','"+role_id+"','"+currentTime+"','"+created_by+"','"+usershift+"','"+mispunch+"')";
								stmt.executeUpdate(sql_user); */
										String sql_updateshift = "UPDATE duty_rosters " +
                                        "SET intime='"+currentTime+"',is_present='Y',role_id='"+role_id+"',created_by='"+created_by+"' WHERE id='"+shiftalreadyapplied+"'";
								 	    stmt.executeUpdate(sql_updateshift);
									}
								
							 
							 }
						}
							 
						
				break;
					}
                     else
                        this.jLabelStatus.setText( "Verification Failed. Please try again");
                 else
                    this.jLabelStatus.setText( "Verification Attempt Fail - MatchTemplate() Error : " + iError);
                 
             }                             
         }
         else
            this.jLabelStatus.setText( "Verification Attempt Fail - MatchTemplate() Error : " + iError); 
                              }
							  
							
                		
                		}
                		
                	}catch(Exception exception){
                		exception.printStackTrace();
                	}
					
		if(isUserexist== "1" || isUserexist=="0")			
		    getAppletContext().showDocument(getDocumentBase(), "_self");				
                
    }//GEN-LAST:event_jButtonVerifyActionPerformed

    private void jButtonRegisterActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButtonRegisterActionPerformed
         int[] matchScore = new int[1];
         boolean[] matched = new boolean[1];
         long iError;
         long secuLevel = (long) (this.jComboBoxRegisterSecurityLevel.getSelectedIndex() + 1);
         matched[0] = false;
         
         iError = fplib.MatchTemplate(regMin1,regMin2, secuLevel, matched); 
         if (iError == SGFDxErrorCode.SGFDX_ERROR_NONE)
         {
             matchScore[0] = 0;
             iError = fplib.GetMatchingScore(regMin1, regMin2, matchScore);

             if (iError == SGFDxErrorCode.SGFDX_ERROR_NONE)
             {
			     try{
                		/*Class.forName("com.mysql.jdbc.Driver");
					   DriverManager.setLoginTimeout(50);
					   conn = DriverManager.getConnection("jdbc:mysql://50.57.95.139:3306/db_life_test?connectTimeout=5000" ,"root","nokia9822xoli1724");*/
					   /*conn = DriverManager.getConnection("jdbc:mysql://50.57.95.139:3306/db_lifespringtest" ,"root","nokia9822xoli1724");*/
                		if(conn != null){
                			
							stmt = conn.createStatement();
							String baseregMin1 = DatatypeConverter.printBase64Binary(regMin1);
							String baseregMin2 = DatatypeConverter.printBase64Binary(regMin2);					
							URL appletUrl = getDocumentBase();
							
							
							//String baseMatched = DatatypeConverter.printBase64Binary(matched);
							//String sql = "INSERT INTO test (regmin1,remin2g,test) " + "VALUES ('"+baseregMin1+"','"+baseregMin2+"','"+appletUrl.getQuery()+"')";
							
							 //String sql = "UPDATE persons " +
                               //    "SET regmin1='"+baseregMin1+"', regmin2='"+baseregMin2+"' WHERE id = '"+appletUrl.getQuery()+"'";
							   
							   String sql = "UPDATE users " +
                                   "SET regmin1='"+baseregMin1+"', regmin2='"+baseregMin2+"' WHERE id = '"+appletUrl.getQuery()+"'";
                            stmt.executeUpdate(sql);
							
                		
                		}
                		
                		
                		this.jLabelStatus.setText("First registration image was captured");
//                		this.connectDb();
                	}catch(Exception exception){
                		exception.printStackTrace();
                	}
					
					
                 if (matched[0])
                     this.jLabelStatus.setText( "Registration Success, Matching Score: " + matchScore[0]);
                 else
                     this.jLabelStatus.setText( "Registration Fail, Matching Score: " + matchScore[0]);
                     
             }
             else
                this.jLabelStatus.setText( "Registration Fail, GetMatchingScore() Error : " + iError);
         }
             else
                this.jLabelStatus.setText( "Registration Fail, MatchTemplate() Error : " + iError);
        
    }//GEN-LAST:event_jButtonRegisterActionPerformed

    public void jButtonCaptureV1ActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButtonCaptureV1ActionPerformed
        int[] quality = new int[1];
        byte[] imageBuffer1 = ((java.awt.image.DataBufferByte) imgVerification.getRaster().getDataBuffer()).getData();
        long iError = SGFDxErrorCode.SGFDX_ERROR_NONE;
		
		
         
        iError = fplib.GetImageEx(imageBuffer1,jSliderSeconds.getValue() * 1000, 0, jSliderQuality.getValue());                
        fplib.GetImageQuality(deviceInfo.imageWidth, deviceInfo.imageHeight, imageBuffer1, quality); 
        this.jProgressBarV1.setValue(quality[0]);
        SGFingerInfo fingerInfo = new SGFingerInfo();
        fingerInfo.FingerNumber = SGFingerPosition.SG_FINGPOS_LI;
        fingerInfo.ImageQuality = quality[0];
        fingerInfo.ImpressionType = SGImpressionType.SG_IMPTYPE_LP;
        fingerInfo.ViewNumber = 1;

        if (iError == SGFDxErrorCode.SGFDX_ERROR_NONE)
        {            
            this.jLabelVerifyImage.setIcon(new ImageIcon(imgVerification.getScaledInstance(130,150,Image.SCALE_DEFAULT)));
            if (quality[0] == 0)
                this.jLabelStatus.setText("GetImageEx() Success [" + ret + "] but image quality is [" + quality[0] + "]. Please try again"); 
            else
            {
                this.jLabelStatus.setText("GetImageEx() Success [" + ret + "]"); 
             
                iError = fplib.CreateTemplate(fingerInfo, imageBuffer1, vrfMin);
                if (iError == SGFDxErrorCode.SGFDX_ERROR_NONE)
                {
                   this.jLabelStatus.setText("Verification image was captured");
				   v1Captured = true;
				   this.jButtonVerifyActionPerformed(evt);
                   this.enableRegisterAndVerifyControls();
                }
                else
                   this.jLabelStatus.setText("CreateTemplate() Error : " + iError);
            }
         }
         else
            this.jLabelStatus.setText("Problem capturing image. Please try again");
        
        
    }//GEN-LAST:event_jButtonCaptureV1ActionPerformed

    private void jButtonCaptureR2ActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButtonCaptureR2ActionPerformed
        
        int[] quality = new int[1];
        byte[] imageBuffer1 = ((java.awt.image.DataBufferByte) imgRegistration2.getRaster().getDataBuffer()).getData();
        long iError = SGFDxErrorCode.SGFDX_ERROR_NONE;
         
        iError = fplib.GetImageEx(imageBuffer1,jSliderSeconds.getValue() * 1000, 0, jSliderQuality.getValue());       
        fplib.GetImageQuality(deviceInfo.imageWidth, deviceInfo.imageHeight, imageBuffer1, quality); 
        this.jProgressBarR2.setValue(quality[0]);
        SGFingerInfo fingerInfo = new SGFingerInfo();
        fingerInfo.FingerNumber = SGFingerPosition.SG_FINGPOS_LI;
        fingerInfo.ImageQuality = quality[0];
        fingerInfo.ImpressionType = SGImpressionType.SG_IMPTYPE_LP;
        fingerInfo.ViewNumber = 1;

        if (iError == SGFDxErrorCode.SGFDX_ERROR_NONE)
        {            
            this.jLabelRegisterImage2.setIcon(new ImageIcon(imgRegistration2.getScaledInstance(130,150,Image.SCALE_DEFAULT)));
            if (quality[0] == 0)
                this.jLabelStatus.setText("GetImageEx() Success [" + ret + "] but image quality is [" + quality[0] + "]. Please try again"); 
            else
            {            
                this.jLabelStatus.setText("GetImageEx() Success [" + ret + "]"); 

                iError = fplib.CreateTemplate(fingerInfo, imageBuffer1, regMin2);
                if (iError == SGFDxErrorCode.SGFDX_ERROR_NONE)
                {
                   this.jLabelStatus.setText("Second registration image was captured");
                   r2Captured = true;
                   this.enableRegisterAndVerifyControls();
                }
                else
                   this.jLabelStatus.setText("CreateTemplate() Error : " + iError);
            }
         }
         else
            this.jLabelStatus.setText("Problem capturing image. Please try again");
        
        
    }//GEN-LAST:event_jButtonCaptureR2ActionPerformed

    private void jButtonCaptureR1ActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButtonCaptureR1ActionPerformed
        int[] quality = new int[1];
        byte[] imageBuffer1 = ((java.awt.image.DataBufferByte) imgRegistration1.getRaster().getDataBuffer()).getData();
        long iError = SGFDxErrorCode.SGFDX_ERROR_NONE;
         
        iError = fplib.GetImageEx(imageBuffer1,jSliderSeconds.getValue() * 1000, 0, jSliderQuality.getValue());        
        fplib.GetImageQuality(deviceInfo.imageWidth, deviceInfo.imageHeight, imageBuffer1, quality);
        this.jProgressBarR1.setValue(quality[0]);
        SGFingerInfo fingerInfo = new SGFingerInfo();
        fingerInfo.FingerNumber = SGFingerPosition.SG_FINGPOS_LI;
        fingerInfo.ImageQuality = quality[0];
        fingerInfo.ImpressionType = SGImpressionType.SG_IMPTYPE_LP;
        fingerInfo.ViewNumber = 1;

        if (iError == SGFDxErrorCode.SGFDX_ERROR_NONE)
        {            
            this.jLabelRegisterImage1.setIcon(new ImageIcon(imgRegistration1.getScaledInstance(130,150,Image.SCALE_DEFAULT)));
            if (quality[0] == 0)
                this.jLabelStatus.setText("GetImageEx() Success [" + ret + "] but image quality is [" + quality[0] + "]. Please try again"); 
            else
            {
            
                this.jLabelStatus.setText("GetImageEx() Success [" + ret + "]"); 

                iError = fplib.CreateTemplate(fingerInfo, imageBuffer1, regMin1);
                if (iError == SGFDxErrorCode.SGFDX_ERROR_NONE)
                {

					
    // Do something with the Connection

                	try{
                		               		
                		this.jLabelStatus.setText("First registration image was captured");
//                		this.connectDb();
                	}catch(Exception exception){
                		exception.printStackTrace();
                	}
  
                    
										
                   //this.jLabelStatus.setText("First registration image was captured");
                    r1Captured = true;
                    this.enableRegisterAndVerifyControls();
                }
                 else
                   this.jLabelStatus.setText("Problem capturing image. Please try again");
            }
         }
         else
            this.jLabelStatus.setText("Problem capturing image. Please try again");
                
    }//GEN-LAST:event_jButtonCaptureR1ActionPerformed

    private void jButtonCaptureActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButtonCaptureActionPerformed
        int[] quality = new int[1];        
        BufferedImage img1gray = new BufferedImage(deviceInfo.imageWidth, deviceInfo.imageHeight, BufferedImage.TYPE_BYTE_GRAY);
        byte[] imageBuffer1 = ((java.awt.image.DataBufferByte) img1gray.getRaster().getDataBuffer()).getData();
        if (fplib != null)
        {
            ret = fplib.GetImageEx(imageBuffer1,jSliderSeconds.getValue() * 1000, 0, jSliderQuality.getValue());
            if (ret == SGFDxErrorCode.SGFDX_ERROR_NONE)
            {
                this.jLabelImage.setIcon(new ImageIcon(img1gray));
                long ret2 = fplib.GetImageQuality(deviceInfo.imageWidth, deviceInfo.imageHeight, imageBuffer1, quality);
                this.jLabelStatus.setText("GetImageEx() Success [" + ret + "]" + " Image Quality [" + quality[0] + "]"); 
				jButtonVerifyActionPerformed(evt);
            }
            else
            {
                this.jLabelStatus.setText("Problem capturing image. Please try again");                                
            }
        } 
        else
        {
            this.jLabelStatus.setText("Please connect fingerprint device to the system.");
        }        

    }//GEN-LAST:event_jButtonCaptureActionPerformed

    private void jButtonToggleLEDActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButtonToggleLEDActionPerformed
        if (fplib != null)
        {
            bLEDOn = !bLEDOn;
            ret = fplib.SetLedOn(bLEDOn);
            if (ret == SGFDxErrorCode.SGFDX_ERROR_NONE)
            {
                this.jLabelStatus.setText("SetLedOn(" + bLEDOn + ") Success [" + ret + "]");                
            }
            else
            {
                this.jLabelStatus.setText("SetLedOn(" + bLEDOn + ") Error [" + ret + "]");                                
            }
        } 
        else
        {
            this.jLabelStatus.setText("Please connect fingerprint device to the system.");
        }        
    }//GEN-LAST:event_jButtonToggleLEDActionPerformed

    private void jButtonInitActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jButtonInitActionPerformed
        int selectedDevice = jComboBoxDeviceName.getSelectedIndex();
        switch(selectedDevice)
        {
            case 0: //USB
            default:
                this.deviceName = SGFDxDeviceName.SG_DEV_AUTO;
                break;
            case 1: //FDU04
                this.deviceName = SGFDxDeviceName.SG_DEV_FDU04;
                break;
            case 2: //CN_FDU03
                this.deviceName = SGFDxDeviceName.SG_DEV_FDU03;
                break;
            case 3: //CN_FDU02
                this.deviceName = SGFDxDeviceName.SG_DEV_FDU02;
                break;
        }
        fplib = new JSGFPLib();
        
        ret = fplib.Init(this.deviceName);
        if ((fplib != null) && (ret  == SGFDxErrorCode.SGFDX_ERROR_NONE))
        {
            this.jLabelStatus.setText("Device ready");
            this.devicePort = SGPPPortAddr.USB_AUTO_DETECT;
            switch (this.jComboBoxUSBPort.getSelectedIndex())
            {
                case 1:
                case 2:
                case 3:
                case 4:
                case 5:
                case 6:
                case 7:
                case 8:
                case 9:
                case 10:
                    this.devicePort = this.jComboBoxUSBPort.getSelectedIndex() - 1;
                    break;
            }
            ret = fplib.OpenDevice(devicePort);
            if (ret == SGFDxErrorCode.SGFDX_ERROR_NONE)
            {
                this.jLabelStatus.setText("Device ready");       
                ret = fplib.GetDeviceInfo(deviceInfo);
                if (ret == SGFDxErrorCode.SGFDX_ERROR_NONE)
                {
                    this.jTextFieldSerialNumber.setText(new String(deviceInfo.deviceSN()));
                    this.jTextFieldBrightness.setText(new String(Integer.toString(deviceInfo.brightness)));
                    this.jTextFieldContrast.setText(new String(Integer.toString((int)deviceInfo.contrast)));
                    this.jTextFieldDeviceID.setText(new String(Integer.toString(deviceInfo.deviceID)));
                    this.jTextFieldFWVersion.setText(new String(Integer.toHexString(deviceInfo.FWVersion)));
                    this.jTextFieldGain.setText(new String(Integer.toString(deviceInfo.gain)));
                    this.jTextFieldImageDPI.setText(new String(Integer.toString(deviceInfo.imageDPI)));
                    this.jTextFieldImageHeight.setText(new String(Integer.toString(deviceInfo.imageHeight)));
                    this.jTextFieldImageWidth.setText(new String(Integer.toString(deviceInfo.imageWidth)));
                    imgRegistration1 = new BufferedImage(deviceInfo.imageWidth, deviceInfo.imageHeight, BufferedImage.TYPE_BYTE_GRAY);
                    imgRegistration2 = new BufferedImage(deviceInfo.imageWidth, deviceInfo.imageHeight, BufferedImage.TYPE_BYTE_GRAY);
                    imgVerification = new BufferedImage(deviceInfo.imageWidth, deviceInfo.imageHeight, BufferedImage.TYPE_BYTE_GRAY);
                    this.enableControls();
					//conn=connect();
                }
                else
                    this.jLabelStatus.setText("Please connect fingerprint device to the system.");                                
            }
            else
                this.jLabelStatus.setText("OpenDevice() Error [" + ret + "]");                                
        }
        else
            this.jLabelStatus.setText("JSGFPLib Initialization Failed");
        
        
    }//GEN-LAST:event_jButtonInitActionPerformed
    
    /** Exit the Application */    
    /**
     * @param args the command line arguments
     */
    public static void main(String args[]) {
        //Not used: new JSGD().show();
    	
		
    }
    
    
    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JButton jButtonCapture;
    private javax.swing.JButton jButtonCaptureR1;
    private javax.swing.JButton jButtonCaptureR2;
    private javax.swing.JButton jButtonCaptureV1;
    private javax.swing.JButton jButtonClose;
    private javax.swing.JButton jButtonConfig;
    private javax.swing.JButton jButtonGetDeviceInfo;
    private javax.swing.JButton jButtonInit;
    private javax.swing.JButton jButtonRegister;
    private javax.swing.JButton jButtonToggleLED;
    private javax.swing.JButton jButtonVerify;
    private javax.swing.JComboBox jComboBoxDeviceName;
    private javax.swing.JComboBox jComboBoxRegisterSecurityLevel;
    private javax.swing.JComboBox jComboBoxUSBPort;
    private javax.swing.JComboBox jComboBoxVerifySecurityLevel;
    private javax.swing.JLabel jLabel1;
    private javax.swing.JLabel jLabel2;
    private javax.swing.JLabel jLabel3;
    private javax.swing.JLabel jLabelBrightness;
    private javax.swing.JLabel jLabelContrast;
    private javax.swing.JLabel jLabelDeviceID;
    private javax.swing.JLabel jLabelDeviceInfoGroup;
    private javax.swing.JLabel jLabelDeviceName;
    private javax.swing.JLabel jLabelFWVersion;
    private javax.swing.JLabel jLabelGain;
    private javax.swing.JLabel jLabelImage;
    private javax.swing.JLabel jLabelImageDPI;
    private javax.swing.JLabel jLabelImageHeight;
    private javax.swing.JLabel jLabelImageWidth;
    private javax.swing.JLabel jLabelRegisterImage1;
    private javax.swing.JLabel jLabelRegisterImage2;
    private javax.swing.JLabel jLabelRegistration;
    private javax.swing.JLabel jLabelRegistrationBox;
    private javax.swing.JLabel jLabelSecurityLevel;
    private javax.swing.JLabel jLabelSerialNumber;
    private javax.swing.JLabel jLabelSpacer1;
    private javax.swing.JLabel jLabelSpacer2;
    private javax.swing.JLabel jLabelStatus;
    private javax.swing.JLabel jLabelVerification;
    private javax.swing.JLabel jLabelVerificationBox;
    private javax.swing.JLabel jLabelVerifyImage;
    private javax.swing.JPanel jPanelDeviceInfo;
    private javax.swing.JPanel jPanelImage;
    private javax.swing.JPanel jPanelRegisterVerify;
    private javax.swing.JProgressBar jProgressBarR1;
    private javax.swing.JProgressBar jProgressBarR2;
    private javax.swing.JProgressBar jProgressBarV1;
    private javax.swing.JSlider jSliderQuality;
    private javax.swing.JSlider jSliderSeconds;
    private javax.swing.JTabbedPane jTabbedPane1;
    private javax.swing.JTextField jTextFieldBrightness;
    private javax.swing.JTextField jTextFieldContrast;
    private javax.swing.JTextField jTextFieldDeviceID;
    private javax.swing.JTextField jTextFieldFWVersion;
    private javax.swing.JTextField jTextFieldGain;
    private javax.swing.JTextField jTextFieldImageDPI;
    private javax.swing.JTextField jTextFieldImageHeight;
    private javax.swing.JTextField jTextFieldImageWidth;
    private javax.swing.JTextField jTextFieldSerialNumber;
    // End of variables declaration//GEN-END:variables
    
}
