/**
 * 
 */
package com.example.layouttest;

import android.opengl.GLES20;

/**
 * @author max
 *
 */
public class Triangle extends BaseObject {

	/**
	 * 
	 */
	public Triangle() {
		super();
		mGLType = GLES20.GL_TRIANGLES;
		mVertexColorBuffer = _initFloatBuffer2(mVertexColorData);
		mStrideBytes = 7;
		mVertexOffset = 0;
		mColorOffset = COORDS_PER_VERTEX;
		mVertexColorCount = mVertexColorData.length;
		
		mColorBuffer = _initFloatBuffer2(mColorData);
		
		mColor = mColorData;
		
		mInitShaders();
		
		
	}
	
	static private float mVertexColorData[] = {
		// x,y,z
		// r,g,b,a
		-2.0f, -1.0f, -1.0f,
		0.0f, 1.0f, 0.0f, 1.0f,
		
		-1.0f, -1.0f, -2.0f,
		0.0f, 1.0f, 0.0f, 1.0f,
		
		-2.0f, -1.0f, -1.0f,
		0.0f, 1.0f, 0.0f, 1.0f
	};
	static private float mColorData[] = {
		// r,g,b,a
		0.0f, 1.0f, 0.0f, 1.0f,
		0.0f, 1.0f, 0.0f, 1.0f,
		0.0f, 1.0f, 0.0f, 1.0f
	};

}
