package com.example.layouttest;

import java.nio.ByteBuffer;
import java.nio.ByteOrder;
import java.nio.FloatBuffer;

import android.opengl.GLES20;
import android.util.Log;

public class BaseObject {
	
	public static final int SIZE_OF_SHORT     = 2;
	public static final int SIZE_OF_FLOAT     = 4;
	public static final int COORDS_PER_VERTEX = 3;
	public static final int COORDS_PER_COLOR  = 4; 

	public BaseObject() {
//		mColormode = COLOR_MODES.MULTI_COLOR;
	}
	
	public void draw( float[] MVPMatrix ) {
		
		GLES20.glUseProgram(mProgram);
		
		int positionHandle = GLES20.glGetAttribLocation(mProgram, "aPosition");
		Utility.checkHandle(positionHandle, "aPosition");
		
		mVertexColorBuffer.position(mVertexOffset);
		
		GLES20.glEnableVertexAttribArray(positionHandle);
		GLES20.glVertexAttribPointer( 	positionHandle, 
										COORDS_PER_VERTEX, 
										GLES20.GL_FLOAT, 
										false, 
										mStrideBytes, 
										mVertexColorBuffer);
		
		mVertexColorBuffer.position(mColorOffset);
		
//		int colorHandle = GLES20.glGetUniformLocation(mProgram, "vColor");
//		GLES20.glUniform4fv(colorHandle, 1, mColor, 0 );
		
		int colorHandle = GLES20.glGetAttribLocation(mProgram, "aColor");
		
		GLES20.glEnableVertexAttribArray(colorHandle);
		
		GLES20.glVertexAttribPointer(	colorHandle, 
										COORDS_PER_COLOR, 
										GLES20.GL_FLOAT, 
										false, 
										mStrideBytes, 
										mVertexColorBuffer);
//		GLES20.glVertexAttribPointer(	colorHandle, 
//										COORDS_PER_COLOR, 
//										GLES20.GL_FLOAT, 
//										false, 
//										0, 
//										mColorBuffer);
//		
		
		
		// get handle to shapes transformation matrix
		int MvPMatrixHandle = GLES20.glGetUniformLocation(mProgram, "uMVPMatrix");
		Utility.logGLErrors("aquiring MvpMatrixHandle");

		//		// apply projection matrix and view transform
		GLES20.glUniformMatrix4fv(MvPMatrixHandle, 1, false, MVPMatrix, 0);
		
		GLES20.glDrawArrays(mGLType, 0, mVertexColorCount);
		
		GLES20.glDisableVertexAttribArray(positionHandle);

	}
	
	protected void mInitShaders() {
		int vertexShader = MyGLES20Renderer.loadShader( GLES20.GL_VERTEX_SHADER, 
				MyGLES20Renderer.vertexShaderCode );
		int fragmentShader = MyGLES20Renderer.loadShader(GLES20.GL_FRAGMENT_SHADER,
				MyGLES20Renderer.fragmentShaderCode);
		
		mProgram = GLES20.glCreateProgram();
		GLES20.glAttachShader(mProgram, vertexShader);
		GLES20.glAttachShader(mProgram, fragmentShader);
		GLES20.glLinkProgram(mProgram); 

	}
	
	protected int 			mGLType;
	
//	enum COLOR_MODES { SINGLE_COLOR, MULTI_COLOR };
//	COLOR_MODES				mColormode;
	
	protected FloatBuffer 	mVertexColorBuffer;
	protected int 			mVertexColorCount;

	protected FloatBuffer 	mVertexBuffer;
	protected FloatBuffer 	mColorBuffer;
	protected int 			mVertexCount;
	protected int			mColorCount;
	
	protected int			mProgram;
	
	protected float 		mColor[];
	
	protected int 			mVertexOffset;
	protected int 			mColorOffset;
	protected int 			mStrideBytes;
	
	protected void _initFloatBuffer( float[] data, FloatBuffer buffer ) {
		ByteBuffer bb = ByteBuffer.allocateDirect( data.length * SIZE_OF_FLOAT );
		bb.order( ByteOrder.nativeOrder() );
		
		buffer = bb.asFloatBuffer();
		buffer.put(data);
		buffer.position(0);
		
	}
	
	protected FloatBuffer _initFloatBuffer2( float[] data ) {
		ByteBuffer bb = ByteBuffer.allocateDirect( data.length * SIZE_OF_FLOAT );
		bb.order( ByteOrder.nativeOrder() );
		
		FloatBuffer buffer;
		buffer = bb.asFloatBuffer();
		buffer.put(data);
		buffer.position(0);
		
		return buffer;
	}
}
